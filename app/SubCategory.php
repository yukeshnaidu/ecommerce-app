<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

    protected $fillable = ['name', 'category_id', 'parent_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(SubCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(SubCategory::class, 'parent_id');
    }

    public function ancestors()
    {
        $ancestors = collect([]);
        $parent = $this->parent;

        while ($parent)
        {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors->reverse()->values();
    }

    public function getFullPathAttribute(){
        $path = collect([$this->category]);
        $path = $path->merge($this->ancestors);
        $path->push($this);

        return $path;
    }

}
