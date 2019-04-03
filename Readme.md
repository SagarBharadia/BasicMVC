# BasicMVC

BasicMVC is what the name entails, a basic model-view-controller php framework.
It is extremely lightweight and only includes what is required. As such there is no autoloader as of yet as to follow the lightweight approach. It will be constantly updated with new features, contributors or I include, and will be a open source project free for anyone to use or to learn from!

## Installation

Clone the repository and place the files into the `/htdocs` folder of your desired web server. Point the server directory to within the `/path/to/htdocs/public`

This is to minimise the exposure of files to the client side. All server requests will be made to `/public/index.php`.

## Usage

At it's most basic usage, create a new controller within `/controllers/`
in the format `[name].controller.php` replacing the `[name]` with the name of the page the controller will control. For example, if you wanted a to create page such as `domain.com/mywebpage`, the name of the controller will be `mywebpage.controller.php`. The requests that are handled consist of `GET, POST, PUT, UPDATE, DELETE`. A `GET` request is the default if no other is specified. If a `POST` request is made and no hidden `_method` field is given, it will default to `POST`, otherwise if a `_method` field is defined with a value from `PUT, UPDATE, DELETE` then it will choose that function. Below is the mapping function of `request type => function to be run`.
```
'GET' => get()
'POST' => post()
'PUT' => put()
'UPDATE' => update()
'DELETE' => delete()
```
For a visual example, please open the `example.controller.php`.

## Documentation

There is currently no documentation for the framework, however I do abide by the rule of 'readable code' so if you were to look over the src within the `vendor/BasicMVC/core/` it would be straight forward to understand.

I am in the midst of setting up a web server and migrating my site, once done I will be updating it with documentation of this project! 

Thanks for looking over and I hope this gives a beginning insight to MVC architecture.

## Contributing
All pull requests are welcome! For really big changes I ask to open a issue so we can discuss! Thank you!

## License
[MIT](https://choosealicense.com/licenses/mit/)