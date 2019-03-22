
# TwitchCord
Authors:
* Michael Cannucci
* Ruben Sanchez

E-Commerce Project 
Vanier College 

# Description
Community platform for streamers

# Setup
1. Install XAMPP
2. Place project inside htdocs or change DocumentRoot in httpd.conf
```
Changing DocumentRoot EX:
DocumentRoot "C:\Users\Name\source\php\TwitchCord\Public"
<Directory "C:\Users\Name\source\php\TwitchCord\Public">
```
4. Install npm (or Node)
5. Open command prompt and change directory to Frontend
```
cd Frontend
```
6. Install modules for Vue with:
```
npm install
```
7. Build Vue Frontend views
```
npm run build
```

# Workflow

### Setting up a new View
1. Create a Controller and .php View
2. Create a new page inside /Frontend/vue.config.js
```
//Example page inside vue.config.js
//Page should be equal to a .php View
signin: {
	entry:  'src/pages/SignIn/main.js',
	template:  'public/index.html',
	title:  'Sign Up',
	chunks: ['chunk-vendors', 'chunk-common']
}
```
3. Run 'npm run build' 
4.  Link transpiled js files
	* in this case the js files produced are for the sign in page (change signin to what ever the transpiler names it)	
```
<?php
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		
		<title>TwitchCord</title>
		<link rel=icon href=Vue/favicon.ico> 
		<link href=Vue/chunk-vendors.js rel=preload as=script>
		<link href=Vue/css/chunk-vendors.css rel=preload as=style>
		<link href=Vue/css/signin.css rel=preload as=style>
		<link href=Vue/signin.js rel=preload as=script>
		<link href=Vue/css/chunk-vendors.css rel=stylesheet>
		<link href=Vue/css/signin.css rel=stylesheet>
	</head>
	<body>
		<noscript>
		We're sorry, this website needs javascript to function
		</noscript>
		<div id=app></div>
		<script src=Vue/chunk-vendors.js></script> 
    	<script src=Vue/sigin.js> </script> 
	</body>
</html>
```

### Development tips

Running 'npm run watch' while inside the 'Frontend' will transpile any changes you've made and push them into the 'Public' folder. This is much better than running 'npm run build' after every change you've made, now to see any changes made within the .vue files is to refresh the browser's page

