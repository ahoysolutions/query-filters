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
To be completed.

### Adding filter methods
To be completed.

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