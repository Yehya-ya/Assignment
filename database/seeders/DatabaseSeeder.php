<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $category = Category::factory()->create(['title' => 'Category A']);
        for ($i=1;$i<4;$i++) {
            $subCategory = Category::factory()->create(['category_id' => $category->id, 'title' => 'Sub A-'.$i]);
            for ($j=1;$j<4;$j++) {
                $subSubCategory = Category::factory()->create(['category_id' => $subCategory->id, 'title' => 'Sub Sub A-'.$i.'-'.$j]);
                for ($z=1;$z<4;$z++) {
                    Category::factory()->create(['category_id' => $subSubCategory->id, 'title' => 'Sub Sub Sub A-'.$i.'-'.$j.'-'.$z]);
                }
            }
        }
        $category = Category::factory()->create(['title' => 'Category B']);
        for ($i=1;$i<4;$i++) {
            $subCategory = Category::factory()->create(['category_id' => $category->id, 'title' => 'Sub B-'.$i]);
            for ($j=1;$j<4;$j++) {
                $subSubCategory = Category::factory()->create(['category_id' => $subCategory->id, 'title' => 'Sub Sub B-'.$i.'-'.$j]);
                for ($z=1;$z<4;$z++) {
                    Category::factory()->create(['category_id' => $subSubCategory->id, 'title' => 'Sub Sub Sub B-'.$i.'-'.$j.'-'.$z]);
                }
            }
        }
        $category = Category::factory()->create(['title' => 'Category C']);
        for ($i=1;$i<4;$i++) {
            $subCategory = Category::factory()->create(['category_id' => $category->id, 'title' => 'Sub C-'.$i]);
            for ($j=1;$j<4;$j++) {
                $subSubCategory = Category::factory()->create(['category_id' => $subCategory->id, 'title' => 'Sub Sub C-'.$i.'-'.$j]);
                for ($z=1;$z<4;$z++) {
                    Category::factory()->create(['category_id' => $subSubCategory->id, 'title' => 'Sub Sub Sub C-'.$i.'-'.$j.'-'.$z]);
                }
            }
        }
    }
}
