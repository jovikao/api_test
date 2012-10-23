var system = require('system'), page = require('webpage').create();
var vw, vh, agent, url, img_path;
if (system.args.length < 6) {
        console.log("Usage: screenshot.js viewport_width viewport_height browser_user_agent url img_path");
} else {
    vw = system.args[1];
    vh = system.args[2];
    agent = system.args[3];
    url = system.args[4];
    img_path = system.args[5];
}
page.settings.userAgent = agent;
page.viewportSize = { width: vw, height: vh };

//page.clipRect = { top: 12, left: 86.5, width: 204, height: 115 };
page.open(url, function (status) {
    var t = Date.now();
    if (status !== 'success') {
        console.log('FAIL to load the address');
        phantom.exit(-1);
    } else {
        t = Date.now() - t;
        //console.log('Loading time ' + t + ' msec');
        window.setTimeout(function () {
            page.render(img_path);
            phantom.exit();
        }, 100);
    }
});
