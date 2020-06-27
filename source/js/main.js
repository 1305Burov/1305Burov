$(document).ready(function() {
	$('.works__filter_btn[filter]').click(function(){
		 if($(this).attr('filter')=='all') {
			if($(this).attr('val')=='off') {
				$('.works__filter_btn[filter]').attr('val', 'off');
				$(this).attr('val','on');
				$('.works__filter_btn[filter]').removeClass('focused')
				$(this).addClass('focused')
				$('.filter > div').show(300);
			}
		} else
		if($(this).attr('val')=='off') {
			$('.works__filter_btn[filter]').attr('val', 'off');
			$(this).attr('val','on');
			$('.works__filter_btn[filter]').removeClass('focused')
			$(this).addClass('focused')
			$('.filter > div').hide(300);
			var filter = $(this).attr('filter');
			$('.filter > div[filter='+filter+']').show(300);
		}
	})
				
})

window.addEventListener('DOMContentLoaded', () => {
    const menu = document.querySelector('.menu'),
    menuItem = document.querySelectorAll('.menu_item'),
    hamburger = document.querySelector('.hamburger');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('hamburger_active');
        menu.classList.toggle('menu_active');
    });

    menuItem.forEach(item => {
        item.addEventListener('click', () => {
            hamburger.classList.toggle('hamburger_active');
            menu.classList.toggle('menu_active');
        })
    })
})
