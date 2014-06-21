<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="../static/js/threejs/three.min.js"></script>
    <script type="text/javascript" src="../static/js/physi.js"></script>

    <script type="text/javascript">

    'use strict';

    Physijs.scripts.worker = '../static/js/physijs_worker.js';
    Physijs.scripts.ammo = '../js/cannon.js';

    var initScene, render, renderer, scene, camera, box;
    var totalboxes = 0;

    initScene = function() {
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize( window.innerWidth, window.innerHeight );
        document.getElementById( 'viewport' ).appendChild( renderer.domElement );

        scene = new Physijs.Scene({ fixedTimeStep: 1 / 120 });
        scene.setGravity(new THREE.Vector3( 0, -10, 0 ));

        camera = new THREE.PerspectiveCamera(
            35,
            window.innerWidth / window.innerHeight,
            1,
            0
        );
        camera.position.set( 60, 50, 60 );
        camera.lookAt( scene.position );
        scene.add( camera );

        // Ground
        var ground_material = Physijs.createMaterial(
            new THREE.MeshBasicMaterial({ color: 0x888888 }),
            1.5, // high friction
            .1 // low restitution
        );

        var ground = new Physijs.BoxMesh(
            new THREE.CubeGeometry(300, 3, 300),
            ground_material,
            0 // mass
        );
        ground.receiveShadow = true;
        scene.add( ground );

        spawnBox();

        requestAnimationFrame( render );
    };

    render = function() {
        scene.simulate(); // run physics
        renderer.render( scene, camera); // render the scene
        requestAnimationFrame( render );
    };

    window.onload = initScene;

function spawnBox() {
            var box_geometry = new THREE.CubeGeometry( 1, 1, 1 );
            var box, material;

            material = Physijs.createMaterial(
                new THREE.MeshLambertMaterial({ color: 0x881188 }),
                1.5, // medium friction
                .1 // low restitution
            );

            //material = new THREE.MeshLambertMaterial({ map: THREE.ImageUtils.loadTexture( 'images/rocks.jpg' ) });

            box = new Physijs.BoxMesh(
                box_geometry,
                material,
                1
            );

            box.position.set(
                Math.random() * 15 - 7.5,
                25,
                Math.random() * 15 - 7.5
            );

            box.rotation.set(
                Math.random() * Math.PI,
                Math.random() * Math.PI,
                Math.random() * Math.PI
            );

            box.castShadow = true;
            scene.add( box );

            if(totalboxes < 10)
                window.setTimeout(spawnBox,3000);
            totalboxes++;
    }
    </script>
</head>

<body>
    <div id="viewport"></div>
</body>
</html>