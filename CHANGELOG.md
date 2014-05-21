### To-Do ###
- Admin Panel
	- Settings Page
		- Add "Set Home Page ID" setting
		- update schema
	- Menu/Navigation Manager
		Table Structure:
			-id NOT UNIQUE - use this id to associate multiple menu item rows with a single menu name
			-Menu Name - Should be the same for all menu items with the same ID
			-Item Name
			-Item URL
			- update schema
	- Components
		- Add functions field
		- Create schema for components
		- Integrate with existing .comp files.
		- update schema
	-Styles and Design
		- Back-End syntax highlighting
		- Design layouts
		- Implement Markup
		- Implement Styles
		- Implement Jacasript
- Threebasicdefault Template
	- Add background color field
	- Animation
		-Add 'Enable Animation' bit.
		-Add Animation custom script textarea
		-Update schema
	- Loading Manager
	- Scene Transitions
	- more complex post processing (Gods Rays, lens flare, bokeh, etc.)
	- GUI
	- update schema
- System
	- Display pages by title slug OR id (requires site settings option)
	- Mod_Rewrite Upgrades
	- Extract Functions from code into files
	- Review Model -> Action relationship.

### Wishlist ####
- Integrated Scene Exporter
- In-scene web using CSS3D renderer
- Animation Manager
- Script Manager
- GUI Manager
- Easy Install

### Bugs ###
- Second component in array/list not coming through. Maybe SQL query is bad.
- After creating things you get logged out

### 0.0.10 ###
- Added components page to admin controller
- Adjusted mod_rewrite rules to default non-numeric params to '1'
- Added page_manager view to admin controller
- Added Component manager, editor, and creator views
- Added components table.
- Integrated components array in threebasicdefault view.

### 0.0.9 ###
- Fixed window resize console error.
- PageContent HTML fields now save and output properly.
- Javascript fields now save and output properly.
- Register controller now requires admin permission.
- Updated schemas.
- Created site_settings page, controller, and table.
- Defined constants for site settings.
- Added resource_manager action to admin controller.
	- Added file type toggling to resource manager.
	- Added file upload to resource manager.
	- Added file removal to resource manager.

### 0.0.8 ###
- Moved editor action to admin controller as page_editor
- Fixed a bug in the threebasicdefault template
- Created 'page_creator' action on admin controller
- Created 'page_deleter' action on admin controller
- Created rudimentary dashboard admin page.
- Update createPage() to reflect POST extraction on updatePage().
- Corrected bug which caused rendershaders to not function.
- Linked SceneTex to scene object.

### 0.0.7 ###
- Fixed fog bug
- threebasicdefault/editor is now functioning
- Created scriptincludes class
- Created skybox class
- Editor defaults to page id 1 but takes params (/threebasicdefault/editor/12)
- Set threebasicdefault as the default template
- Set mod_rewrite rules to inperpret numeric params on homepage

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
- Added material class
- Added particle class
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