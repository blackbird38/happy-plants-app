module.exports = {
    theme: {},
    variants: {},
    plugins: [
        require('tailwindcss-animatecss')({
            settings: {
                animatedSpeed: 1000,
                heartBeatSpeed: 1000,
                hingeSpeed: 2000,
                bounceInSpeed: 750,
                bounceOutSpeed: 750,
                animationDeplaySpeed: 1000
            },
            variants: ['responsive'],
        }),
    ],
}