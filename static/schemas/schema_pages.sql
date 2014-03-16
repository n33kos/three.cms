DROP TABLE IF EXISTS pages;
CREATE TABLE pages
(
  id              smallint unsigned NOT NULL auto_increment,
  publicationDate date NOT NULL,
  title           varchar(255) NOT NULL,
  summary         text NOT NULL,
  pagecontent     mediumtext NOT NULL,

  canvastarget varchar(255) NOT NULL,
  scriptincludes mediumtext NOT NULL,
  usepixelshaders int NOT NULL,
  shaderincludes mediumtext NOT NULL,
  showstats int NOT NULL,
  rendermode varchar(255) NOT NULL,
  aobit int NOT NULL,
  aabit int NOT NULL,
  controlmode varchar(255) NOT NULL,
  cameraposition varchar(255) NOT NULL,
  cameraperspective varchar(255) NOT NULL,
  camnear varchar(255) NOT NULL,
  camfar varchar(255) NOT NULL,
  lights mediumtext NOT NULL,
  materials mediumtext NOT NULL,
  realtimeshadowsbit int NOT NULL,
  realtimeshadowsmooth varchar(255) NOT NULL,
  linearfogbit int NOT NULL,
  linearfogcolor varchar(255) NOT NULL,
  linearfognear varchar(255) NOT NULL,
  linearfogfar varchar(255) NOT NULL,
  exponentialfogbit int NOT NULL,
  exponentialfogcolor varchar(255) NOT NULL,
  exponentialfogdensity varchar(255) NOT NULL,
  scenefile varchar(255) NOT NULL,
  scenetex varchar(255) NOT NULL,
  useskybox int NOT NULL,
  skyboxscale varchar(255) NOT NULL,
  skyboxtextures mediumtext NOT NULL,
  custominits mediumtext NOT NULL,
  custombody mediumtext NOT NULL,
  customrender mediumtext NOT NULL,

  PRIMARY KEY     (id)
);