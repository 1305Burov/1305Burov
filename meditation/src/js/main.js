//modal 

const modalBtn = document.querySelectorAll('.learnMore_btn'),
    modal = document.querySelector('.modal');

modalBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        const target = e.target;
        if (target.classList.contains('hero__btn')) {
            document.querySelector('.modal__heading').textContent = 'Get start';
            modal.classList.remove('hidden');
        }else if (target.classList.contains('modal__button') === false) {
            document.querySelector('.modal__heading').textContent = 'Learn more';
            modal.classList.remove('hidden');
        }else {
            e.preventDefault();
        }
    });
});

modal.addEventListener('click', (e) => {
    const target = e.target;
    if (target.classList.contains('overlay') || target.classList.contains('modal__close')) {
        modal.classList.add('hidden');    
    }
});

//modal END

//Smooth scroll

const links = document.querySelectorAll('.header__nav_list__item_link'),
    footerLinks = document.querySelectorAll('.footer__nav__list_item_link'),
    mobMenu = document.querySelectorAll('.menu__item_link'),
    scrollElements = [...links, ...footerLinks, ...mobMenu];

scrollElements.forEach((link) => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const id = event.target.getAttribute('href').substr(1);
        document.getElementById(id).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

//Smooth scroll END

//Active menu

const sections = document.querySelectorAll('section');
document.addEventListener('scroll', e => {
    let scrollDist = window.scrollY;
    sections.forEach((elem, i) => {
        if (elem.offsetTop - document.querySelector('.header__nav_list').clientHeight - 300 <= scrollDist) {
            links.forEach(el => {
                if (el.classList.contains('active')) {
                    el.classList.remove('active');
                }
            });

            links[i].classList.add('active');
        }
    });
});

//Active menu END


//Music player

const playPlayer = document.querySelector('.music__player'),
    music = document.querySelectorAll('.audio'),
    playerBtn = document.querySelectorAll('.music__player__item_btn');

playPlayer.addEventListener('click', (e) => {
    let target = e.target;

    if (target.classList.contains('music__player__item_btn')) {
        if (!target.classList.contains('paused')) {
            music.forEach(item => {
                item.pause();
            })
    
            playerBtn.forEach(item => {
                item.classList.remove('paused');
            })

            music[target.id].play();
            target.classList.add('paused');
        }else {
            music[target.id].pause();
            target.classList.remove('paused');
        }

        music[target.id].addEventListener('ended',function() {
            target.classList.remove('paused');
        });
    }
    
})

//Music plater END

//Ham menu 

const menu = document.querySelector('.menu'),
    menuItem = document.querySelectorAll('.menu_item'),
    ham = document.querySelector('.ham');

    ham.addEventListener('click', () => {
        ham.classList.toggle('ham_active');
        menu.classList.toggle('menu_active');
    });

    menuItem.forEach(item => {
        item.addEventListener('click', () => {
            ham.classList.toggle('ham_active');
            menu.classList.toggle('menu_active');
        })
    })
    
//Ham menu  END