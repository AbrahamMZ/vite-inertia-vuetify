import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader
import { createVuetify } from "vuetify";
import { es } from "vuetify/locale";

export default createVuetify({
    icons: {
        defaultSet: "mdi", // This is already the default value - only for display purposes
    },
    locale: {
        locale: "es",
        messages: { es },
        current: "es",
    },
});
