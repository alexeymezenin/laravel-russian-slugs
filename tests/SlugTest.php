<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use AlexeyMezenin\RussianSeoSlugs\Slug;

class SlugTest extends TestCase
{

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

    public function testDoesSlugUrlStaticCallWork()
    {
        $this->assertEquals(
            'ничего_на_свете_лучше_нету',
            Slug::getSlug('Ничего на свете лучше нету', '_', 1, false)
        );

        $this->assertEquals(
            'чем-бродить-друзьям-по-белу-свету',
            Slug::getSlug('Чем бродить друзьям по белу свету', '-', 1, false)
        );

        $this->assertEquals(
            'Тем_кто_дружен',
            Slug::getSlug('Тем, кто дружен', '_', 1, true)
        );

        $this->assertEquals(
            'Ne-strashny-trevogi',
            Slug::getSlug('Не страшны тревоги...', '-', 2, true)
        );

        $this->assertEquals(
            'nam_lyubye_dorogi_dorogi',
            Slug::getSlug('Нам любые дороги дороги!', '_', 2, false)
        );
    }
}
