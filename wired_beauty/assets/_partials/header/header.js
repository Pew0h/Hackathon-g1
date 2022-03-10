document.addEventListener( 'DOMContentLoaded', () =>
{
    let toggle_menu = document.querySelector( '#toggle-menu' ),
        nav_secondary = document.querySelector( '#nav-secondary' )
    
    toggle_menu.addEventListener( 'click', () => nav_secondary.classList.toggle( 'active' ) )
} )