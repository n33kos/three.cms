### To-Do ###
- Admin Template
	- landing page
	- site-specific settings page
	- Page management/overview
		- Update createPage() to reflect POST extraction on updatePage().
	- Media Upload (hefty)
	- Menu/Navigation system
	- GUI
- Threebasicdefault Template
	- Debug errors on default template
	- In-scene html using CSS3D renderer
	- GUI implementation
	- Integrated Scene Exporter on editor action
	- Loading Manager
	- Scene Transitions
	- more complex post processing (Gods Rays, lens flare, bokeh, etc.)
- Components
	- Better component structure (database?)
	- per component settings
	- 'Smooth transition' Preset camera positions.
- System
	- Better mod_rewrite rules
- Everything else

### 0.0.7 ###
- Fixed fog bug
- threebasicdefault/editor is now functioning
- Created scriptincludes class
- Editor defaults to page id 1 but takes params (/threebasicdefault/editor/12)

### 0.0.6 ###
- Created admin template and controller
- Tweaked mod_rewrite logic to support 1 param
- Added Login Controller
- Added Register Controller

### 0.0.5 ###
- Created pages schema
- Created page class
- Created database 
- Model now pulls from database instead of config file.
- Added basic mod_rewrite to handle controller and action

### 0.0.4 ###
- Added Fallback scene, 10x10x10 groundplane
- Added a material class
- Added a particle class
- Added Materials component
- Added Custom Javascript init, body, and render vars
- Added html page content
- Implemented togglable stats
- Combined loose variables into tpl_args on model level

### 0.0.3 ###
- Ported to basic MVC framework
- Flipped dev1 branch with Master
- Created branch dev1 for MVC conversion
- Added light class to enable array based lighting
- Added per-light settings
- Added Antialiasing
- Improved Ambient Occlusion

### 0.0.2 ###
- Added realtime shading and shadow blend methods
- Added Default Lighting Rigs: directional, hemisphere, ambient, point, area, spot
- Added Pointerlock controls
- Fixed some bugs related to render shaders

### 0.0.1 ###
Template Experimentation:
- Added Fog
- Added ambient occlusion (Mostly Broken)
- Added Render Shaders
- Added flycontrols and orbit controls
- Added Camera options(position, perspective)
- Added Skybox Option
- Added options for WebGL, Canvas, and ACSII render modes.
- Added config file
- Added very basic scene loading
- Began default template construction
