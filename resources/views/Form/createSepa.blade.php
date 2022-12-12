<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Stripe SEPA Debit</title>
    <meta name="description" content="A demo of Stripe Payment Intents" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://js.stripe.com/v3/"></script>
    <style>
      /**
      * The CSS shown here will not be introduced in the Quickstart guide, but
      * shows how you can use CSS to style your Element's container.
      */
      input,
      .StripeElement {
        height: 40px;
        padding: 10px 12px;

        color: #32325d;
        background-color: white;
        border: 1px solid transparent;
        border-radius: 4px;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
      }

      input:focus,
      .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
      }

      .StripeElement--invalid {
        border-color: #fa755a;
      }

      .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
      }

      /* Variables */
      :root {
        --body-color: rgb(247, 250, 252);
        --button-color: rgb(30, 166, 114);
        --accent-color: #32325d;
        --link-color: #6b7c93;
        --font-color: rgb(105, 115, 134);
        --error-color: #fa755a;
        --body-font-family: -apple-system, BlinkMacSystemFont, sans-serif;
        --radius: 6px;
        --form-width: 600px;
      }

      /* Base */
      * {
        box-sizing: border-box;
      }
      body {
        font-family: var(--body-font-family);
        font-size: 16px;
        -webkit-font-smoothing: antialiased;
      }

      /* Layout */
      .sr-root {
        display: flex;
        flex-direction: row;
        width: 100%;
        max-width: 980px;
        padding: 48px;
        align-content: center;
        justify-content: center;
        height: auto;
        min-height: 100vh;
        margin: 0 auto;
      }
      .sr-main {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        width: var(--form-width);
        min-width: 450px;
        align-self: center;
        padding: 75px 50px;
        background: var(--body-color);
        border-radius: var(--radius);
        box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
          0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
      }

      .sr-field-error {
        color: var(--error-color);
        text-align: left;
        font-size: 13px;
        line-height: 17px;
        margin-top: 12px;
      }

      /* Inputs */
      input {
        width: 100%;
        outline: none;
      }
      .sr-input,
      input[type="text"] {
        border: 1px solid var(--gray-border);
        border-radius: var(--radius);
        padding: 5px 12px;
        height: 44px;
        width: 100%;
        outline: none;
        transition: box-shadow 0.2s ease;
        background: white;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
      }
      .sr-input:focus,
      input[type="text"]:focus,
      button:focus,
      .focused {
        box-shadow: 0 0 0 1px rgba(50, 151, 211, 0.3), 0 1px 1px 0 rgba(0, 0, 0, 0.07),
          0 0 0 4px rgba(50, 151, 211, 0.3);
        outline: none;
        z-index: 9;
      }
      .sr-input::placeholder,
      input[type="text"]::placeholder {
        color: var(--gray-light);
      }
      .sr-result {
        height: 44px;
        -webkit-transition: height 1s ease;
        -moz-transition: height 1s ease;
        -o-transition: height 1s ease;
        transition: height 1s ease;
        color: var(--font-color);
        overflow: auto;
      }
      .sr-result code {
        overflow: scroll;
      }
      .sr-result.expand {
        height: 350px;
      }

      .sr-combo-inputs-row {
        display: -ms-flexbox;
        display: flex;
      }
      .sr-combo-inputs-row {
        width: 100%;
        margin-top: 20px;
      }
      .sr-combo-inputs-row:first-child {
        margin-top: 0;
      }
      .sr-combo-inputs-row {
        margin-top: 20px;
      }
      .sr-combo-inputs-row .col:not(:last-child) {
        margin-right: 20px;
      }
      .sr-combo-inputs-row .col {
        width: 100%;
      }

      /* Input labels */
      label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
        max-width: 100%;
        color: #6b7c93;
      }

      /* Buttons and links */
      button {
        background: var(--accent-color);
        border-radius: var(--radius);
        color: white;
        border: 0;
        padding: 12px 16px;
        margin-top: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: block;
        box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
        width: 100%;
      }
      button:hover {
        filter: contrast(115%);
      }
      button:active {
        transform: translateY(0px) scale(0.98);
        filter: brightness(0.9);
      }
      button:disabled {
        opacity: 0.5;
        cursor: none;
      }

      a {
        color: var(--link-color);
        text-decoration: none;
        transition: all 0.2s ease;
      }

      a:hover {
        filter: brightness(0.8);
      }

      a:active {
        filter: brightness(0.5);
      }

      /* Code block */
      code,
      pre {
        font-family: "SF Mono", "IBM Plex Mono", "Menlo", monospace;
        font-size: 12px;
      }

      /* Stripe Element placeholder */
      .sr-element {
        padding-top: 12px;
      }

      /* Responsiveness */
      @media (max-width: 720px) {
        .sr-root {
          flex-direction: column;
          justify-content: flex-start;
          padding: 48px 20px;
          min-width: 320px;
        }

        .sr-header__logo {
          background-position: center;
        }

        .sr-payment-summary {
          text-align: center;
        }

        .sr-content {
          display: none;
        }

        .sr-main {
          width: 100%;
          height: 450px;
          background: rgb(247, 250, 252);
          box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
            0px 2px 5px 0px rgba(50, 50, 93, 0.1),
            0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
          border-radius: 6px;
        }
      }

      /* todo: spinner/processing state, errors, animations */

      .spinner,
      .spinner:before,
      .spinner:after {
        border-radius: 50%;
      }
      .spinner {
        color: #ffffff;
        font-size: 22px;
        text-indent: -99999px;
        margin: 0px auto;
        position: relative;
        width: 20px;
        height: 20px;
        box-shadow: inset 0 0 0 2px;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
      }
      .spinner:before,
      .spinner:after {
        position: absolute;
        content: "";
      }
      .spinner:before {
        width: 10.4px;
        height: 20.4px;
        background: var(--accent-color);
        border-radius: 20.4px 0 0 20.4px;
        top: -0.2px;
        left: -0.2px;
        -webkit-transform-origin: 10.4px 10.2px;
        transform-origin: 10.4px 10.2px;
        -webkit-animation: loading 2s infinite ease 1.5s;
        animation: loading 2s infinite ease 1.5s;
      }
      .spinner:after {
        width: 10.4px;
        height: 10.2px;
        background: var(--accent-color);
        border-radius: 0 10.2px 10.2px 0;
        top: -0.1px;
        left: 10.2px;
        -webkit-transform-origin: 0px 10.2px;
        transform-origin: 0px 10.2px;
        -webkit-animation: loading 2s infinite ease;
        animation: loading 2s infinite ease;
      }

      @-webkit-keyframes loading {
        0% {
          -webkit-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @keyframes loading {
        0% {
          -webkit-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }

      /* Animated form */

      .sr-root {
        animation: 0.4s form-in;
        animation-fill-mode: both;
        animation-timing-function: ease;
      }

      .hidden {
        display: none;
      }

      @keyframes field-in {
        0% {
          opacity: 0;
          transform: translateY(8px) scale(0.95);
        }
        100% {
          opacity: 1;
          transform: translateY(0px) scale(1);
        }
      }

      @keyframes form-in {
        0% {
          opacity: 0;
          transform: scale(0.98);
        }
        100% {
          opacity: 1;
          transform: scale(1);
        }
      }

      #mandate-acceptance {
        margin: 20px 0;
        font-size: 14px;
        text-align: justify;
      }

      .checkbox,
      .radio {
        position: relative;
        display: block;
        margin-top: 10px;
        margin-bottom: 10px;
      }
      .checkbox label,
      .radio label {
        min-height: 20px;
        padding-left: 20px;
        margin: 20px 0;
        font-weight: 400;
        cursor: pointer;
      }
      .checkbox input[type="checkbox"],
      .checkbox-inline input[type="checkbox"],
      .radio input[type="radio"],
      .radio-inline input[type="radio"] {
        position: absolute;
        margin-top: -12px;
        margin-left: -20px;
        box-shadow: none;
      }
      
        /* Document
          ========================================================================== */

        /**
        * 1. Correct the line height in all browsers.
        * 2. Prevent adjustments of font size after orientation changes in iOS.
        */

        html {
          line-height: 1.15; /* 1 */
          -webkit-text-size-adjust: 100%; /* 2 */
        }
        
        /* Sections
          ========================================================================== */
        
        /**
        * Remove the margin in all browsers.
        */
        
        body {
          margin: 0;
        }
        
        /**
        * Render the `main` element consistently in IE.
        */
        
        main {
          display: block;
        }
        
        /**
        * Correct the font size and margin on `h1` elements within `section` and
        * `article` contexts in Chrome, Firefox, and Safari.
        */
        
        h1 {
          font-size: 2em;
          margin: 0.67em 0;
        }
        
        /* Grouping content
          ========================================================================== */
        
        /**
        * 1. Add the correct box sizing in Firefox.
        * 2. Show the overflow in Edge and IE.
        */
        
        hr {
          box-sizing: content-box; /* 1 */
          height: 0; /* 1 */
          overflow: visible; /* 2 */
        }
        
        /**
        * 1. Correct the inheritance and scaling of font size in all browsers.
        * 2. Correct the odd `em` font sizing in all browsers.
        */
        
        pre {
          font-family: monospace, monospace; /* 1 */
          font-size: 1em; /* 2 */
        }
        
        /* Text-level semantics
          ========================================================================== */
        
        /**
        * Remove the gray background on active links in IE 10.
        */
        
        a {
          background-color: transparent;
        }
        
        /**
        * 1. Remove the bottom border in Chrome 57-
        * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
        */
        
        abbr[title] {
          border-bottom: none; /* 1 */
          text-decoration: underline; /* 2 */
          text-decoration: underline dotted; /* 2 */
        }
        
        /**
        * Add the correct font weight in Chrome, Edge, and Safari.
        */
        
        b,
        strong {
          font-weight: bolder;
        }
        
        /**
        * 1. Correct the inheritance and scaling of font size in all browsers.
        * 2. Correct the odd `em` font sizing in all browsers.
        */
        
        code,
        kbd,
        samp {
          font-family: monospace, monospace; /* 1 */
          font-size: 1em; /* 2 */
        }
        
        /**
        * Add the correct font size in all browsers.
        */
        
        small {
          font-size: 80%;
        }
        
        /**
        * Prevent `sub` and `sup` elements from affecting the line height in
        * all browsers.
        */
        
        sub,
        sup {
          font-size: 75%;
          line-height: 0;
          position: relative;
          vertical-align: baseline;
        }
        
        sub {
          bottom: -0.25em;
        }
        
        sup {
          top: -0.5em;
        }
        
        /* Embedded content
          ========================================================================== */
        
        /**
        * Remove the border on images inside links in IE 10.
        */
        
        img {
          border-style: none;
        }
        
        /* Forms
          ========================================================================== */
        
        /**
        * 1. Change the font styles in all browsers.
        * 2. Remove the margin in Firefox and Safari.
        */
        
        button,
        input,
        optgroup,
        select,
        textarea {
          font-family: inherit; /* 1 */
          font-size: 100%; /* 1 */
          line-height: 1.15; /* 1 */
          margin: 0; /* 2 */
        }
        
        /**
        * Show the overflow in IE.
        * 1. Show the overflow in Edge.
        */
        
        button,
        input { /* 1 */
          overflow: visible;
        }
        
        /**
        * Remove the inheritance of text transform in Edge, Firefox, and IE.
        * 1. Remove the inheritance of text transform in Firefox.
        */
        
        button,
        select { /* 1 */
          text-transform: none;
        }
        
        /**
        * Correct the inability to style clickable types in iOS and Safari.
        */
        
        button,
        [type="button"],
        [type="reset"],
        [type="submit"] {
          -webkit-appearance: button;
        }
        
        /**
        * Remove the inner border and padding in Firefox.
        */
        
        button::-moz-focus-inner,
        [type="button"]::-moz-focus-inner,
        [type="reset"]::-moz-focus-inner,
        [type="submit"]::-moz-focus-inner {
          border-style: none;
          padding: 0;
        }
        
        /**
        * Restore the focus styles unset by the previous rule.
        */
        
        button:-moz-focusring,
        [type="button"]:-moz-focusring,
        [type="reset"]:-moz-focusring,
        [type="submit"]:-moz-focusring {
          outline: 1px dotted ButtonText;
        }
        
        /**
        * Correct the padding in Firefox.
        */
        
        fieldset {
          padding: 0.35em 0.75em 0.625em;
        }
        
        /**
        * 1. Correct the text wrapping in Edge and IE.
        * 2. Correct the color inheritance from `fieldset` elements in IE.
        * 3. Remove the padding so developers are not caught out when they zero out
        *    `fieldset` elements in all browsers.
        */
        
        legend {
          box-sizing: border-box; /* 1 */
          color: inherit; /* 2 */
          display: table; /* 1 */
          max-width: 100%; /* 1 */
          padding: 0; /* 3 */
          white-space: normal; /* 1 */
        }
        
        /**
        * Add the correct vertical alignment in Chrome, Firefox, and Opera.
        */
        
        progress {
          vertical-align: baseline;
        }
        
        /**
        * Remove the default vertical scrollbar in IE 10+.
        */
        
        textarea {
          overflow: auto;
        }
        
        /**
        * 1. Add the correct box sizing in IE 10.
        * 2. Remove the padding in IE 10.
        */
        
        [type="checkbox"],
        [type="radio"] {
          box-sizing: border-box; /* 1 */
          padding: 0; /* 2 */
        }
        
        /**
        * Correct the cursor style of increment and decrement buttons in Chrome.
        */
        
        [type="number"]::-webkit-inner-spin-button,
        [type="number"]::-webkit-outer-spin-button {
          height: auto;
        }
        
        /**
        * 1. Correct the odd appearance in Chrome and Safari.
        * 2. Correct the outline style in Safari.
        */
        
        [type="search"] {
          -webkit-appearance: textfield; /* 1 */
          outline-offset: -2px; /* 2 */
        }
        
        /**
        * Remove the inner padding in Chrome and Safari on macOS.
        */
        
        [type="search"]::-webkit-search-decoration {
          -webkit-appearance: none;
        }
        
        /**
        * 1. Correct the inability to style clickable types in iOS and Safari.
        * 2. Change font properties to `inherit` in Safari.
        */
        
        ::-webkit-file-upload-button {
          -webkit-appearance: button; /* 1 */
          font: inherit; /* 2 */
        }
        
        /* Interactive
          ========================================================================== */
        
        /*
        * Add the correct display in Edge, IE 10+, and Firefox.
        */
        
        details {
          display: block;
        }
        
        /*
        * Add the correct display in all browsers.
        */
        
        summary {
          display: list-item;
        }
        
        /* Misc
          ========================================================================== */
        
        /**
        * Add the correct display in IE 10+.
        */
        
        template {
          display: none;
        }
        
        /**
        * Add the correct display in IE 10.
        */
        
        [hidden] {
          display: none;
        }
    </style>
  </head>

  <body>
    <div class="sr-root">
      <div class="sr-main">
        <form id="payment-form" class="sr-payment-form" action="{{route('storeSepa')}}" method="POST">
          @csrf
          <div class="sr-combo-inputs-row">
            <div class="col">
              <label for="name">
                Name
              </label>
              <input id="name" name="name" placeholder="Jenny Rosen" required />
            </div>
            <div class="col">
              <label for="email">
                Email Address
              </label>
              <input
                id="email"
                name="email"
                type="email"
                placeholder="jenny.rosen@example.com"
                required
              />
            </div>
          </div>

          <div class="sr-combo-inputs-row">
            <div class="col">
              <label for="iban-element">
                IBAN
              </label>
              <div id="iban-element">
                <!-- A Stripe Element will be inserted here. -->
                {{-- <div id="iban-element" class="StripeElement StripeElement--empty"><div class="__PrivateStripeElement" style="margin: 0px !important; padding: 0px !important; border: none !important; display: block !important; background: transparent !important; position: relative !important; opacity: 1 !important;"><iframe name="__privateStripeFrame4086" frameborder="0" allowtransparency="true" scrolling="no" role="presentation" allow="payment *" src="https://js.stripe.com/v3/elements-inner-iban-d38d61bd280f8fc8ea9194378616ae27.html#wait=false&amp;mids[guid]=NA&amp;mids[muid]=NA&amp;mids[sid]=NA&amp;style[base][color]=%2332325d&amp;style[base][fontFamily]=-apple-system%2C+BlinkMacSystemFont%2C+%22Segoe+UI%22%2C+Roboto%2C+Helvetica%2C+Arial%2C+sans-serif&amp;style[base][fontSmoothing]=antialiased&amp;style[base][fontSize]=16px&amp;style[base][::placeholder][color]=%23aab7c4&amp;style[base][:-webkit-autofill][color]=%2332325d&amp;style[invalid][color]=%23fa755a&amp;style[invalid][iconColor]=%23fa755a&amp;style[invalid][:-webkit-autofill][color]=%23fa755a&amp;placeholderCountry=DE&amp;supportedCountries[0]=SEPA&amp;rtl=false&amp;componentName=iban&amp;keyMode=test&amp;apiKey=pk_test_PInFiPUnGR6pzLYZ2IE6oyPf&amp;referrer=https%3A%2F%2Fqry5s.sse.codesandbox.io%2F&amp;controllerId=__privateStripeController4081" title="Secure IBAN input frame" style="border: none !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; user-select: none !important; transform: translate(0px) !important; color-scheme: light only !important; height: 19.2px;" spellcheck="false"></iframe><input class="__PrivateStripeElement-input" aria-hidden="true" aria-label=" " autocomplete="false" maxlength="1" style="border: none !important; display: block !important; position: absolute !important; height: 1px !important; top: -1px !important; left: 0px !important; padding: 0px !important; margin: 0px !important; width: 100% !important; opacity: 0 !important; background: transparent !important; pointer-events: none !important; font-size: 16px !important;"></div></div> --}}
              </div>
            </div>
          </div>

          <!-- Used to display form errors. -->
          <div id="error-message" class="sr-field-error" role="alert"></div>

          <!-- Display mandate acceptance text. -->
          <div class="col" id="mandate-acceptance" data-secret="{{ $SetupIntent->client_secret }}">
            By providing your IBAN and confirming this payment, you are
            authorizing Rocketship Inc. and Stripe, our payment service
            provider, to send instructions to your bank to debit your account
            and your bank to debit your account in accordance with those
            instructions. You are entitled to a refund from your bank under the
            terms and conditions of your agreement with your bank. A refund must
            be claimed within 8 weeks starting from the date on which your
            account was debited.
          </div>

          <button id="confirm-mandate" data-secret="{{ $PaymentIntent }}">
            <div disabled class="spinner hidden" id="spinner"></div>
            <span id="button-text">Confirm mandate and initiate debit for <span id="order-amount"></span></span>
          </button>
        </form>
        <div class="sr-result hidden">
          <p>Payment processing<br /></p>
          <pre>
            <code></code>
          </pre>
        </div>
      </div>
    </div>

    <script>
      var orderData = {
        items: [{ id: "photo" }]
      };
      var stripe = Stripe('{{ env('STRIPE_KEY') }}');
      document.querySelector("button").disabled = true;
      // Show formatted price information.
      // var price = (20).toFixed(2);
      // console.log(price)
      // var numberFormat = new Intl.NumberFormat(["de-DE"], {
      //   style: "currency",
      //   currency: data.currency,
      //   currencyDisplay: "symbol"
      // });
      document.getElementById("order-amount").innerText = "Price";

      // var createPaymentIntent = function() {
      //   fetch("/pay", {
      //     method: "POST",
      //     headers: {
      //       "Content-Type": "application/json"
      //     },
      //     body: JSON.stringify(orderData)
      //   })
      //     .then(function(result) {
      //       console.log(result);
      //       return result;
      //       // return result.json();
      //     })
      //     .then(function(data) {
      //       console.log(data);
      //       return setupElements(data);
      //     })
      //     .then(function({ stripe, iban, clientSecret }) {
      //       // Handle form submission.
      //       var form = document.getElementById("payment-form");
      //       form.addEventListener("submit", function(event) {
      //         event.preventDefault();
      //         // Validate the form input
      //         if (!event.target.reportValidity()) {
      //           // Form not valid, abort!
      //           console.log('SOmthing went wrong');
      //           return;
      //         }
      //         // Initiate payment when the submit button is clicked
      //         pay(stripe, iban, clientSecret);
      //       });
      //     });
      // };
      // createPaymentIntent();
      // Set up Stripe.js and Elements to use in checkout form


      var setupElements = function() {
        var elements = stripe.elements();
        var style = {
          base: {
            color: "#32325d",
            fontFamily:
              '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
              color: "#aab7c4"
            },
            ":-webkit-autofill": {
              color: "#32325d"
            }
          },
          invalid: {
            color: "#fa755a",
            iconColor: "#fa755a",
            ":-webkit-autofill": {
              color: "#fa755a"
            }
          }
        };
        const cardButton = document.getElementById('confirm-mandate');
        const clientSecret = cardButton.dataset.secret;  
        console.log(cardButton.dataset)
          
        
        var options = {
          style: style,
          supportedCountries: ["SEPA"],
          // If you know the country of the customer, you can optionally pass it to
          // the Element as placeholderCountry. The example IBAN that is being used
          // as placeholder reflects the IBAN format of that country.
          placeholderCountry: "IT"
        };

        var iban = elements.create("iban", options);
        iban.mount("#iban-element");

        iban.on("change", function(event) {
          // Handle real-time validation errors from the iban Element.
          if (event.error) {
            showError(event.error.message);
          }
        });
        // Enable button.
        document.querySelector("button").disabled = false;
        cardButton.addEventListener('click', async (e) => {
        console.log("attempting");
        pay(stripe, iban, clientSecret);
      });
        return {
          stripe: stripe,
          iban: iban,
          clientSecret: clientSecret
        };
      };

      setupElements();
      
      function setupIntent(stripe,PM){
        const mandate = document.getElementById('mandate-acceptance');
        const clientSecret = mandate.dataset.secret;
        console.log(clientSecret)
        stripe
          .confirmSepaDebitSetup(clientSecret, {
            payment_method: PM,
          })
          .then(function(result) {
            if (result.error) {
              showError(result.error.message);
              console.log(result.error.message)
            } else {
              console.log(result)
              // console.log(result.paymentIntent.payment_method)
              // setupIntent(stripe,result.paymentIntent.payment_method);
              // paymentMethodHandler(result.paymentIntent.client_secret,result.paymentIntent.payment_method);
              // orderComplete(result.paymentIntent.client_secret);
            }
          });
      };
      function paymentMethodHandler(client_secret,payment_method) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', payment_method);
            form.appendChild(hiddenInput);
              orderComplete(client_secret);
            form.submit();
        }
      /*
      * Calls stripe.confirmSepaDebitPayment to generate the mandate and initaite the debit.
      */
      var pay = function(stripe, iban, clientSecret) {
        console.log("attempting");
        changeLoadingState(true);
        // Initiate the payment.
        stripe
          .confirmSepaDebitPayment(clientSecret, 
          {
            payment_method: {
              sepa_debit: iban,
              billing_details: {
                name: document.querySelector('input[name="name"]').value,
                email: document.querySelector('input[name="email"]').value,
              },
            },
            setup_future_usage: 'off_session',
          })
          .then(function(result) {
            if (result.error) {
              // Show error to your customer
              showError(result.error.message);
            } else {
              console.log(result)
              // console.log(result.paymentIntent.payment_method)
              // setupIntent(stripe,result.paymentIntent.payment_method);
              paymentMethodHandler(result.paymentIntent.client_secret,result.paymentIntent.payment_method);
              // orderComplete(result.paymentIntent.client_secret);
            }
          });
        
      };

      /* ------- Post-payment helpers ------- */

      /* Shows a success / error message when the payment is complete */
      var orderComplete = function(clientSecret) {
        stripe.retrievePaymentIntent(clientSecret).then(function(result) {
          var paymentIntent = result.paymentIntent;
          var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);

          document.querySelector(".sr-payment-form").classList.add("hidden");
          document.querySelector("pre").textContent = paymentIntentJson;

          document.querySelector(".sr-result").classList.remove("hidden");
          setTimeout(function() {
            document.querySelector(".sr-result").classList.add("expand");
          }, 200);

          changeLoadingState(false);
        });
      };

      var showError = function(errorMsgText) {
        changeLoadingState(false);
        var errorMsg = document.querySelector("#error-message");
        errorMsg.textContent = errorMsgText;
        setTimeout(function() {
          errorMsg.textContent = "";
        }, 4000);
      };

      // Show a spinner on payment submission
      var changeLoadingState = function(isLoading) {
        if (isLoading) {
          document.querySelector("button").disabled = true;
          document.querySelector("#spinner").classList.remove("hidden");
          document.querySelector("#button-text").classList.add("hidden");
        } else {
          document.querySelector("button").disabled = false;
          document.querySelector("#spinner").classList.add("hidden");
          document.querySelector("#button-text").classList.remove("hidden");
        }
      };
    </script>
  </body>
</html>