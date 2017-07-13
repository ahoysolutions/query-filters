# Query Filters

## Installation

### Step 1: Composer
From the command line, run:
```
composer require ahoysolutions/query-filters
```

### Step 2: Service Provider
From within your Laravel application, open `config/app.php` and within the `providers` array, add:

```
AhoySolutions\QueryFilters\QueryFilterServiceProvider::class
```
This will bootstrap the package into Laravel for you.

## Usage

### Adding a filters class to a model
You can add a filter class through artisan command, just like with controllers, models, or other similar resources.  For example, assuming you wanted to leverage filters on your Post model, you might use:

```
php artisan make:queryfilters PostFilters
```

Afterwards, a new query filter class will be added to your ```app/Filters/``` directory.

### Adding filter methods
To add a filter method to an filter class, simply add a function to the class, then register the method's name in the ```$filters``` array.  For example, assume you have an incoming request with a query string that looks like ```www.example.com/posts?user=johnsmith&popular```.

Your filters class might then look like this: 

```
<?php

namespace App\Filters;

use AhoySolutions\QueryFilters\QueryFilters;
use App\User;

class PostFilters extends QueryFilters
{
    /**
    * Registered filters to operate upon.
    *
    * @var array
    */
    protected $filters = ['user', 'popular'];

    /**
    * Filter the posts by the given user.
    *
    * @param string $username
    * @return \Illuminate\Database\Eloquent\Builder
    */
    protected function user(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return $this->builder->where('artist_id', $user->id);
    }

    /**
     * Filter the posts by their popularity.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function popular()
    {
        $this->resetOrderBy();

        return $this->builder->withCount('favorites')->orderBy('favorites_count', 'desc');
    }
}
```

### Filtering for an query string array
Imagine your user wants to search based on an array of different tags, for example:

```
// given url: /posts?tag[]=science&tag[]=music

/**
 * Filter the posts by a given tag.
 *
 * @param string $tag
 * @return \Illuminate\Database\Eloquent\Builder
 */
public function tag(string $tag)
{
    return $this->builder->whereHas('tags', function ($query) use ($tag) {
       return $query->where('name', $tag);
   });;
}
```
As you can see, you don't have to do anything within the filter to allow the user to leverage this functionality.

The relevant query filter will then be called multiple times and apply the filter for each tag.  This is good for checking against many-to-many relationships.

### Adding sortable methods
You can specify that a field should be sortable by calling `$this->resetOrderBy()` before leveraging the builder, for example:

```
// given url: /resource?popular

/**
 * Sorts the posts by their popularity.
 *
 * @return \Illuminate\Database\Eloquent\Builder
 */
protected function popular()
{
    $this->resetOrderBy();

    return $this->builder->withCount('favorites')->orderBy('favorites_count', 'desc');
}
```

If you have multiple sortables, the latest one leveraged by the user will take precedence.

## Credits
* Inspired by [Laracasts](https://laracasts.com) (https://laracasts.com/series/lets-build-a-forum-with-laravel)
* Originally developed by [Chris Sorrells](https://www.chrissorrells.com/) on behalf of [Ahoy Solutions, LLC](https://www.ahoysolutions.com).