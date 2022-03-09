document.addEventListener('DOMContentLoaded', () =>
{
    let input_city = document.querySelector( '#registration_form_city' ),
        api_url = 'https://api-adresse.data.gouv.fr/search/?q=20%20avenue%20de%20S%C3%A9gur%2C%20Paris&type=housenumber&autocomplete=1'

    let search_cities = () =>
    {
        fetch( api_url )
        .then( ( response ) =>
        {
            return response.json().then( ( json ) =>
            {
                    console.log(json)
            })
        } )
    }

    input_city.addEventListener( 'keyup', search_cities)
})


