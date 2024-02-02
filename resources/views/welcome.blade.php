<!DOCTYPE html>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('vendor/video.js/dist/video-js.min.css') }}" />
</head>
<body>
<video
    id="vid1"
    class="video-js vjs-default-skin"
    controls
    width="640" height="264"
    data-setup='{ "techOrder": ["youtube", "html5"] }'
    poster="//vjs.zencdn.net/v/oceans.png"
>
    <source src="//vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
</video>
<button class="oceans">Oceans</button>
<button class="youtube">YouTube</button>

<script src="{{ asset('vendor/video.js/dist/video.js') }}"></script>
<script src="{{ asset('vendor/videojs-youtube/dist/Youtube.js') }}"></script>

<script>
    var oceans = document.querySelector('.oceans');
    var youtube = document.querySelector('.youtube');

    oceans.addEventListener('click', function() {
        var player = videojs.players.vid1;
        player.src({src: '//vjs.zencdn.net/v/oceans.mp4', type: 'video/mp4'});
    });
    youtube.addEventListener('click', function() {
        var player = videojs.players.vid1;
        player.poster('');
        player.src({src: 'https://www.youtube.com/watch?v=xjS6SftYQaQ', type: 'video/youtube'});
    });
</script>
</body>
</html>
