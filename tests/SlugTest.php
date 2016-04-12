<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use AlexeyMezenin\RussianSeoSlugs\Slug;

class SlugTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testRemovingInappropriateSymbols(){
        $s = new Slug('А!Б#В$A%B{C');
        $this->assertEquals('АБВABC', $s->removeInappropriateSymbols()->slug);
    }
    
    public function testReplaceSpacesWithDelimiter(){
        $s = new Slug('Replace all spaces', '_');
        $this->assertEquals('Replace_all_spaces', $s->replaceSpacesWithDelimiter()->slug);
    }

    public function testToLower(){
        $s = new Slug('The Show Must Go On', null, null, false);
        $this->assertEquals('the show must go on', $s->toLower()->slug);

        $s = new Slug('The Show Must Go On', null, null, true);
        $this->assertEquals('The Show Must Go On', $s->toLower()->slug);
    }

    public function testTranslit(){
        $s = new Slug('абвгдеёжзийклмнопрстуфхцчшщъыьэюя');
        $this->assertEquals('abvgdeezhziiklmnoprstufkhtschshschyeyuya', $s->toTranslit()->slug);

        $s = new Slug('абвгдеёжзийклмнопрстуфхцчшщъыьэюя', null, 1);
        $this->assertEquals('абвгдеёжзийклмнопрстуфхцчшщъыьэюя', $s->toTranslit()->slug);
    }
}