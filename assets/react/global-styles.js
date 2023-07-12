import { createGlobalStyle } from "styled-components";
import "@fontsource/inter/700.css";
import "@fontsource/inter/400.css";

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
    overflow: hidden;
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
    font-weight: 400;
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
    --grid-columns: ${(props) => props.config.gridColumns};
    --grid-rows: ${(props) => props.config.gridRows};
    --total-rows: ${(props) => props.config.totalRows};
    --grid-expose: ${(props) => props.config.variant.gridExpose ?? 3};

    /*
      Font
    */
    --font-size-base: clamp(
      1rem,
      1.5vw + 1rem,
      2rem
    );
    --font-weight-normal: 400;
    --font-weight-bold: 700;

    --font-size-xs: calc(var(--font-size-base) * 0.5);
    --font-size-s: calc(var(--font-size-base) * 0.75);
    --font-size-m: var(--font-size-base);
    --font-size-l: calc(var(--font-size-base) * 1.25);
    --font-size-xl: calc(var(--font-size-base) * 1.5);

    /*
      Border
    */
    --tile-border-width: ${(props) =>
      props.config.variant.tileBorderWidth ?? 5}px;
    --border-width: var(--tile-border-width);

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
