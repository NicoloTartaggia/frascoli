import 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v3.0.0/dist/cookieconsent.umd.js';

CookieConsent.run({
    guiOptions: {
        consentModal: {
            layout: "box inline",
            position: "bottom right",
            equalWeightButtons: false,
            flipButtons: true
        },
        preferencesModal: {
            layout: "bar",
            position: "right",
            equalWeightButtons: true,
            flipButtons: false
        }
    },
    categories: {
        necessary: {
            readOnly: true
        },
        analytics: {}
    },
    language: {
        default: "it",
        autoDetect: "browser",
        translations: {
            it: {
                consentModal: {
                    description: "Noi e terze parti selezionate utilizziamo cookie o tecnologie simili per finalità tecniche e, con il tuo consenso, anche per le finalità di misurazione e marketing (con annunci personalizzati) come specificato nella <a href=\"https://www.iubenda.com/privacy-policy/86822110/cookie-policy\">cookie policy</a>. <br>",
                    acceptAllBtn: "Accetta",
                    acceptNecessaryBtn: "Rifiuta",
                },
            }
        }
    }
});
