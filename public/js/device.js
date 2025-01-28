
var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
const pathName = window.location.pathname
fetch('https://api.ipify.org?format=json')
  .then(response => response.json())
  .then(data => {
    checkDevice(data.ip)
  })
  .catch(error => checkDevice(''));

function checkDevice(ipaddress) {
    if ('/login' == pathName) {
        document.getElementById('app_version').value = nVer
        document.getElementById('user_agent').value = nAgt
        document.getElementById('app_name').value = browserName
        document.getElementById('ip_address').value = ipaddress
    } else {
        let data = {} 
        data._token = $('meta[name="csrf-token"]').attr('content');
        data.app_version = nVer;
        data.user_agent = nAgt
        data.app_name = browserName;
        data.ip_address = ipaddress;
        
        $.ajax({
            method: 'post',
            url: '/device',
            data: data,
            jsonp: false,
            error: function () {
                document.getElementById('btn-header-logout').click()
            }
        });
    }
}