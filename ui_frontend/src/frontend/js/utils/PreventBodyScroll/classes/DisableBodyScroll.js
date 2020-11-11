// https://codepen.io/thuijssoon/pen/prwNjO
class disableBodyScroll {

    /**
     * Private variables
     */
    constructor() {
        this._selector = false;
        window._element = false;
        this._clientY = 0;
        /**
         * Polyfills for Element.matches and Element.closest
         */
        if (!Element.prototype.matches)
            Element.prototype.matches = Element.prototype.msMatchesSelector ||
                Element.prototype.webkitMatchesSelector;

        if (!Element.prototype.closest)
            Element.prototype.closest = function (s) {
                var ancestor = this;
                if (!document.documentElement.contains(el)) return null;
                do {
                    if (ancestor.matches(s)) return ancestor;
                    ancestor = ancestor.parentElement;
                } while (ancestor !== null);
                return el;
        };
    }


    /**
     * Prevent default unless within _selector
     *
     * @param  event object event
     * @return void
     */
    preventBodyScroll(event) {
        if (false === window._element || !event.target.closest(this._selector)) {
            event.preventDefault();
        }
    }

    /**
     * Cache the clientY co-ordinates for
     * comparison
     *
     * @param  event object event
     * @return void
     */
    captureClientY(event) {
        // only respond to a single touch
        if (event.targetTouches.length === 1) {
            this._clientY = event.targetTouches[0].clientY;
        }
    }

    /**
     * Detect whether the element is at the top
     * or the bottom of their scroll and prevent
     * the user from scrolling beyond
     *
     * @param  event object event
     * @return void
     */
    preventOverscroll(event) {
        // only respond to a single touch
        if (event.targetTouches.length !== 1) {
            return;
        }

        const clientY = event.targetTouches[0].clientY - this._clientY;

        console.log(window._element);

        // The element at the top of its scroll,
        // and the user scrolls down
        if (window._element.scrollTop === 0 && clientY > 0) {
            event.preventDefault();
        }

        // The element at the bottom of its scroll,
        // and the user scrolls up
        // https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollHeight#Problems_and_solutions
        if ((window._element.scrollHeight - window._element.scrollTop <= window._element.clientHeight) && clientY < 0) {
            event.preventDefault();
        }

    };

    /**
     * Disable body scroll. Scrolling with the selector is
     * allowed if a selector is porvided.
     *
     * @param  boolean allow
     * @param  string selector Selector to element to change scroll permission
     * @return void
     */
    disable(allow, selector) {
        if (typeof selector !== "undefined") {
           this. _selector = selector;
            window._element = document.querySelector(selector);
        }

        console.log(window._element);

        if (true === allow) {
            if (false !== window._element) {
                window._element.addEventListener('touchstart', this.captureClientY, {passive:false});
                window._element.addEventListener('touchmove', this.preventOverscroll, {passive:false});
            }
            document.body.addEventListener("touchmove", this.preventBodyScroll, {passive:false});
        } else {
            if (false !== window._element) {
                window._element.removeEventListener('touchstart', this.captureClientY, {passive:false});
                window._element.removeEventListener('touchmove', this.preventOverscroll, {passive:false});
            }
            document.body.removeEventListener("touchmove", this.preventBodyScroll, {passive:false});
        }
    }
};
export default new disableBodyScroll();
