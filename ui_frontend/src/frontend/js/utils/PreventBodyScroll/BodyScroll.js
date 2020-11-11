import DisableBodyScroll from './classes/DisableBodyScroll.js';
import DetectScrollbar from './classes/DetectScrollbar.js';

class BodyScroll {
    constructor() {
        this.scroll_y = 0;
        this.scroll_x = 0;
        this.scrollableElement = null;
        this.oldMarginTop = 0;
        DetectScrollbar.getScrollBarWidth();
    }

    disable(scrollableElement) {
        this.scroll_y = window.pageYOffset;
        this.scroll_x = window.pageXOffset;
        this.oldMarginTop = document.querySelector('body > div > main').style.marginTop;
        if (DetectScrollbar.hasScrollBar()) {
            document.body.style.paddingRight = `${ DetectScrollbar.getScrollBarWidth() }px`;
        }
        console.log(window.pageYOffset * -1);
        document.querySelector('body > div > main').style.marginTop = window.pageYOffset * -1 + 'px';
        document.querySelector('html').classList.add('bodyscroll--disabled');
        document.body.style.marginTop = window.pageYOffset * -1;
        this.scrollableElement = scrollableElement;
       // DisableBodyScroll.disable(true, scrollableElement);
    }

    enable() {
        //DisableBodyScroll.disable(false, this.scrollableElement);
        document.querySelector('html').classList.remove('bodyscroll--disabled');
        document.body.style.paddingRight = '0';
        document.querySelector('body > div > main').style.marginTop = this.oldMarginTop;
        window.scrollTo(this.scroll_x, this.scroll_y);
    }
}
export default new BodyScroll();
