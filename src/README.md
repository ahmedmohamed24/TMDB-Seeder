
#Movies Seeder
##### current version is `v1`, start all the API routes with ``/api/v1/``
## Technologies:
<p align="center">
    <a href="#">
        <img src="https://img.shields.io/badge/-PHP-f5f5f5?style=for-the-badge&amp;labelColor=grey&amp;logo=PHP&amp;logoColor=white" alt="PHP" style="max-width:100%;">
    </a>
    <a href="#">
        <img src="https://img.shields.io/badge/-MYSQL-075b9a?style=for-the-badge&amp;labelColor=black&amp;logo=Mysql&amp;logoColor=white" alt="MYSQL" style="max-width:100%;">
    </a>
    <a href="#">
        <img src="https://img.shields.io/badge/-Docker-61dafb?style=for-the-badge&amp;labelColor=black&amp;logo=docker&amp;logoColor=61dafb" alt="docker" style="max-width:100%;">
    </a>
    <a href="#">
        <img src="https://img.shields.io/badge/-Postman-F88C00?style=for-the-badge&amp;labelColor=black&amp;logo=postman&amp;logoColor=F88C00" alt="postman" style="max-width:100%;">
    </a>
</p>

###Fetch all movies

```http
  Get /movies
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `category_id` | `string` | **Nullable**. filter by a specific category |
| `original_language` | `string` | **Nullable**. filter by a specific langauge ex: `en|fr` |
| `popular` | `string` | **Nullable**. Order movies by their popularity, only `desc & asc` values are considered|
| `rated` | `string` | **Nullable**. Order movies by their rating, only `desc & asc` values are considered|
| `recently` | `string` | **Nullable**. Order movies by their creation time, only `desc & asc` values are considered|

###Application life cycle
> When the scheduler starts, the cron jobs runs at the specified time to fetch Generes from `The movie DB` (only for first time) and starts the movies jobs to fetch popular movies (20 movies are returned for each request), and attach every movie to its genere, when the number of saved movies in DB equals the number of records specified in .env, the scheduler stops

###Filtering Movies
> Filtering movies by attributes are handled inside `Movie` Model by scope filter. but for category filter, we first gets the category and then paginates over this category movies in our DB

### Some Design Aspects
1. Movie with Genere have a **Many-To-Many** Relationship
1. Service Classes to handle Business Logic (The Movie DB logic handling)
2. Repository pattern to seperate DB logic
3. Uniformed API response Structure using Common trait with helper method
4. Exceptions are translated to API response (NotFoundException in our case)
