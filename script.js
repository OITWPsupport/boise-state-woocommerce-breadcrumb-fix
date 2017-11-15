/* PhotoSwipe Button Fix */
/* Also adds a title att to a Woo form. A11y fix */
jQuery(document).ready(function() {
	jQuery('.pswp__button--close').attr('title', 'Close');
	jQuery('.pswp__button--share').attr('title', 'Share');
	jQuery('.pswp__button--fs').attr('title', 'Toggle fullscreen');
	jQuery('.pswp__button--zoom').attr('title', 'Zoom');
	jQuery('.pswp__button--arrow--left').attr('title', 'Previous (arrow left)');
	jQuery('.pswp__button--arrow--right').attr('title', 'Next (arrow right)');
	jQuery('.orderby').attr('title', 'orderby');
});
