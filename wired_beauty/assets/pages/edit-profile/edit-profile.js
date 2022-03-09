// document.addEventListener( 'DOMContentLoaded', () =>
// {
//     let input_city = document.querySelector( '.search-city-input' ),
//         input_longitude = document.querySelector( '.search-city-longitude' ),
//         input_latitude = document.querySelector( '.search-city-latitude' ),
//         remove_button = document.querySelector( '.search-city__remove' ),
//         api_url = 'https://geo.api.gouv.fr/communes/?lat=%lat%&lon=%lon%'

//     let search_by_lat_long = () =>
//     {
//         if ( input_latitude.value == '' || input_longitude.value == '' ) {
//             return
//         }

//         input_city.value = 'Loading...'
//         input_city.setAttribute( 'readonly', true )
//         input_city.classList.add( 'filled' )

//         let url = api_url.replace( '%lat%', input_latitude.value )
//             url = url.replace( '%lon%', input_longitude.value )

//         fetch( url )
//         .then( async response =>
//         {
//             const json = await response.json()
//             debugger
//         } )
//     }

//     if ( input_city.value == '' ) {
//         search_by_lat_long()
//     }
// } )