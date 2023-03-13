import { createGlobalStyle } from 'styled-components';
import { Settings } from './Data/settings';
import "@fontsource/inter/700.css";

const GlobalStyles = createGlobalStyle`

  /*
  * Josh Comeau Global Styles
  * From his css-for-js course: https://courses.joshwcomeau.com/css-for-js/treasure-trove/010-global-styles
  */


  /*
    1. Use a more-intuitive box-sizing model.
  */
  *, *::before, *::after {
    box-sizing: border-box;
  }

  /*
    2. Remove default margin
  */
  * {
    margin: 0;
  }

  /*
    3. Allow percentage-based heights in the application
  */
  html, body {
    height: 100%;
  }

  /*
    Typographic tweaks!
    4. Add accessible line-height
    5. Improve text rendering
  */
  body {
    line-height: 1.5;
    -webkit-font-smoothing: antialiased;
    font-family: "Inter";
  }

  /*
    6. Improve media defaults
  */
  img, picture, video, canvas, svg {
    display: block;
    max-width: 100%;
  }

  /*
    7. Remove built-in form typography styles
  */
  input, button, textarea, select {
    font: inherit;
  }

  /*
    8. Avoid text overflows
  */
  p, h1, h2, h3, h4, h5, h6 {
    overflow-wrap: break-word;
  }

  /*
    9. Create a root stacking context
  */
  #root, #__next {
    isolation: isolate;
  }

  /*
    Common css variabels placed on root
  */

  :root {

    /*
      Grid settings
    */
    --grid-columns: ${Settings.gridColumns};
    --grid-rows: ${Settings.gridRows};
    --grid-expose: ${Settings.gridExpose};

    /*
      Font
    */
    --font-size-base: clamp(
      1rem,
      1.5vw + 1rem,
      2rem
    );
    --font-size-h2: clamp(
      1.5rem,
      4vw + 1rem,
      4rem
    );
    --font-weight-h2: 700;

    /*
      Border
    */
    --border-width: 5px;


    /*
      Colors
    */
    --color-one: #e5243b;
    --color-two: #dda63a;
    --color-tree: #4c9f38;
    --color-four: #c5192d;
    --color-five: #ff3a21;
    --color-six: #26bde2;
    --color-seven: #fcc30b;
    --color-eight: #a21942;
    --color-nine: #fd6925;
    --color-ten: #dd1367;
    --color-eleven: #fd9d24;
    --color-twelve: #bf8b2e;
    --color-thirteen: #3f7e44;
    --color-fourteen: #0a97d9;
    --color-fifteen: #56c02b;
    --color-sixteen: #00689d;
    --color-white: hsl(0deg 0% 100%);
    --color-black: hsl(0deg 0% 0%);

    /*
      Effects
    */
    --filter-shadow: drop-shadow(0px 4px 16px rgba(0, 0, 0, 0.32));

    /*
      Logo
    */
    --logo-background: var(--color-white);

  }

  @keyframes expose {
    0% {
      visibility: visible;
      opacity: 0;
      clip-path: inset(0 0 100% 0);
    }
    20% {
      transform: translateY(20%);
      opacity: 1;
    }
    100% {
      transform: translateY(0);
      opacity: 1;
      clip-path: inset(0);
    }
  }
`;

export default GlobalStyles;