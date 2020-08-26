define(["jquery/ui","jquery"], function(Component, $){
    return function(config, element){
        var time = config.time;
        var minicart = $(element);
        minicart.on('contentLoading', function () {
            minicart.on('contentUpdated', function () {
                minicart.find('[data-role="dropdownDialog"]').dropdownDialog("open");
                setTimeout(function () {
                    minicart.find('[data-role="dropdownDialog"]').dropdownDialog("close");
                },time );
            });
        });
    }
});
