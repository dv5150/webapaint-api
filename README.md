## API
List shapes for given user

`GET /api/users/2/shapes`

Show selected shape

`GET /api/users/2/shapes/circle/1`

Store new shape

`POST /api/users/2/shapes?type=rectangle&width=50&height=35&color_id=2`

`POST /api/users/2/shapes?type=circle&radius=74&color_id=3`

List worksheets for given user

`GET /api/users/2/worksheets`

Store new worksheet

`POST /api/users/2/worksheets?title=loremipsum`

Add existing shapes to an existing worksheet

`POST /api/users/2/worksheets/1/shapes?id=1&type=circle&x=49&y=82`

## PHPUnit

Run all tests:

`$ php artisan test Tests\\Unit\\API`
