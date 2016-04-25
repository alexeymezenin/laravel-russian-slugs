<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use AlexeyMezenin\LaravelRussianSlugs\Slugs;

class SlugsTest extends TestCase
{
    public function testBuildMethodThroughFacade()
    {
        $this->assertEquals(
            'the_show_must_go_on',
            Slug::build('The Show Must Go On', '_')
        );

        $this->assertEquals(
            'ничего_на_свете_лучше_нету',
            Slug::build('Ничего на свете лучше нету', '_', 1, false)
        );

        $this->assertEquals(
            'чем-бродить-друзьям-по-белу-свету',
            Slug::build('Чем бродить друзьям по белу свету', '-', 1, false)
        );

        $this->assertEquals(
            'Тем_кто_дружен',
            Slug::build('Тем, кто дружен', '_', 1, true)
        );

        $this->assertEquals(
            'Ne-strashny-trevogi',
            Slug::build('Не страшны тревоги...', '-', 2, true)
        );

        $this->assertEquals(
            'nam_lyubye_dorogi_dorogi',
            Slug::build('Нам любые дороги дороги!', '_', 2, false)
        );

    }

    public function testRemovingInappropriateSymbols(){
        $s = new Slugs('А!Б#В$A%B{C');
        $this->assertEquals('АБВABC', $s->removeInappropriateSymbols()->slug);
    }
    
    public function testReplaceSpacesWithDelimiter(){
        $s = new Slugs('Replace all spaces', '_');
        $this->assertEquals('Replace_all_spaces', $s->replaceSpacesWithDelimiter()->slug);

        $s = new Slugs('      Remove    multiple     spaces and trim  string    ', '_');
        $this->assertEquals('Remove_multiple_spaces_and_trim_string', $s->replaceSpacesWithDelimiter()->slug);

        $s = new Slugs('  Trimming string with a special symbol at the end   ', '_');
        $this->assertEquals('Trimming_string_with_a_special_symbol_at_the_end',
                            $s->replaceSpacesWithDelimiter()->removeInappropriateSymbols()->slug);
    }

    public function testToLower(){
        $s = new Slugs('The Show Must Go On', null, null, false);
        $this->assertEquals('the show must go on', $s->toLower()->slug);

        $s = new Slugs('The Show Must Go On', null, null, true);
        $this->assertEquals('The Show Must Go On', $s->toLower()->slug);
    }

    public function testTranslit(){
        $s = new Slugs('абвгдеёжзийклмнопрстуфхцчшщъыьэюя', null, 2);
        $this->assertEquals('abvgdeezhziiklmnoprstufkhtschshschyeyuya', $s->toTranslit()->slug);

        $s = new Slugs('абвгдеёжзийклмнопрстуфхцчшщъыьэюя');
        $this->assertEquals('абвгдеёжзийклмнопрстуфхцчшщъыьэюя', $s->toTranslit()->slug);

        $s = new Slugs('АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ', null, 2, true);
        $this->assertEquals('ABVGDEEZhZIIKLMNOPRSTUFKhTsChShSchYEYuYa', $s->toTranslit()->slug);
    }
}

