<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/waves.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/TweenMax.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/jquery.wavify.js') }}"></script>
<script>
    $('#feel-the-wave').wavify({
        height: 100,
        bones: 3,
        amplitude: 90,
        color: 'rgba(72, 134, 255, 4)',
        speed: .25
    });
    $('#feel-the-wave-two').wavify({
        height: 70,
        bones: 5,
        amplitude: 60,
        color: 'rgba(72, 134, 255, .3)',
        speed: .35
    });
    $('#feel-the-wave-three').wavify({
        height: 50,
        bones: 4,
        amplitude: 50,
        color: 'rgba(72, 134, 255, .2)',
        speed: .45
    });
</script>
