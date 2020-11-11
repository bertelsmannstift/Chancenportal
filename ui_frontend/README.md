# Getting started

Component driven templating using vue.js in backend and frontend. 
There are two webpack configurations one for the frontend "webpack.config.js" and one for the backend. 
To extend the backend webpack config, look in the server.js there you will find a object for extending 
the webpack config. Out of the box there is nothing to do here all you need is implemented.

## Install

```bash
$ npm i
```

## Start development 

```bash
$ npm run dev
```

## Run build

```bash
$ npm run build
```

## Folder structure

| Folder | Description |
|---|---|
| assets | The public server folder. Also Webpack will put all extracted files here. |
| dist | dist will be genereated after you run build. Here are all final static files, drop that to your webserver root |
| src | Contains all the source files for backend rendering and fronend rendering |
| src / styles | Contains your styles |
| src / assets | Drop static files here. |
| src / frontend | Contains all you components that are rendered in the browser |
| src / backend | Contains all you components and pages that are rendered on the server |
| src / mixins | Will be loaded automatically by the server.js. Mixins are shared function across the server components. |
