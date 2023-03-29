const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");


const navyColor = {
    50: "#E7E9EF",
    100: "#C2C9D6",
    200: "#A3ADC2",
    300: "#697A9B",
    400: "#5C6B8A",
    450: "#465675",
    500: "#384766",
    600: "#313E59",
    700: "#26334D",
    750: "#222E45",
    800: "#202B40",
    900: "#192132",
};
const customColors = {
    navy: navyColor,
    "slate-150": "#E9EEF5",
    primary: "#be1d2e",
    secondary: "#23301a",

    "primary-focus": colors.indigo["700"],
    "secondary-light": "#ff57d8",

    "secondary-focus": "#BD0090",
    "accent-light": colors.indigo["400"],
    accent: "#5f5af6",
    "accent-focus": "#4d47f5",
    info: colors.sky["500"],
    "info-focus": colors.sky["600"],
    success: colors.emerald["500"],
    "success-focus": colors.emerald["600"],
    warning: "#ff9800",
    "warning-focus": "#e68200",
    error: "#ff5724",
    "error-focus": "#f03000",
};
module.exports = {
    darkMode: "class",

    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.{vue,js,jsx}",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ...customColors,
                dark: {
                    bg: "#151823",
                    "eval-1": "#222738",
                    "eval-2": "#2A2F42",
                    "eval-3": "#2C3142",
                },
            },
            opacity: {
                15: ".15",
            },
            spacing: {
                4.5: "1.125rem",
                5.5: "1.375rem",
                18: "4.5rem",
            },
            boxShadow: {
                soft: "0 3px 10px 0 rgb(48 46 56 / 6%)",
                "soft-dark": "0 3px 10px 0 rgb(25 33 50 / 30%)",
            },
            zIndex: {
                1: "1",
                2: "2",
                3: "3",
                4: "4",
                5: "5",
            },
            keyframes: {
                "fade-in": {
                    "0%": {
                        opacity: 0,
                    },
                    "100%": {
                        opacity: 1,
                    },
                },
                "fade-out": {
                    "0%": {
                        opacity: 1,
                        visibility: "visible",
                    },
                    "100%": {
                        opacity: 0,
                        visibility: "hidden",
                    },
                },
            },
        },
        screens: {
            sm: "640px",
            // => @media (min-width: 640px) { ... }

            md: "768px",
            // => @media (min-width: 768px) { ... }

            lg: "1024px",
            // => @media (min-width: 1024px) { ... }

            xl: "1280px",
            // => @media (min-width: 1280px) { ... }

            "2xl": "1536px",
            // => @media (min-width: 1536px) { ... }
            "3xl": "1920px",
            // => @media (min-width: 1536px) { ... }
        },
        corePlugins: {
            textOpacity: false,
            backgroundOpacity: false,
            borderOpacity: false,
            divideOpacity: false,
            placeholderOpacity: false,
            ringOpacity: false,
        },
    },

    plugins: [
        require("@tailwindcss/forms"), require("@tailwindcss/line-clamp")
    ],
};
