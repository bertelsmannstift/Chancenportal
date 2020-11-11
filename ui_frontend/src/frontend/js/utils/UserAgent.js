import Bowser from 'bowser';

class UserAgent {
    constructor() {
        this.ua = Bowser.parse(window.navigator.userAgent);
    }
    isIOS() {
        return this.ua.os.name === 'iOS';
    }
    isAndroid() {
        return this.ua.os.name === 'Android';
    }
    isWindowsMobile() {
        return this.ua.os.name === 'Windows Phone';
    }
    isMobile() {
        if ( window.navigator.userAgent.match(/Android/i)
            || window.navigator.userAgent.match(/webOS/i)
            || window.navigator.userAgent.match(/iPhone/i)
            || window.navigator.userAgent.match(/iPad/i)
            || window.navigator.userAgent.match(/iPod/i)
            || window.navigator.userAgent.match(/BlackBerry/i)
            || window.navigator.userAgent.match(/Windows Phone/i)
        ){
            return true;
        }
        else {
            return false;
        }
    }
}
export default new UserAgent();
