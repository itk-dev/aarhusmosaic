import React from "react";
import styled from 'styled-components'
import PropTypes from "prop-types";

function Footer({footerHeight, footerImageSrc, footerBackgroundColor}) {
  return (
    <Wrapper style={{
        '--background-color': footerBackgroundColor,
        '--footer-height': footerHeight
    }}>
      <Img src={footerImageSrc} alt=""/>
    </Wrapper>
  );
}

const Wrapper = styled.div`
  background-color: var(--background-color, hsl(0deg 0% 100%));
  filter: var(--filter-shadow);
  width: 100vw;
  height: calc((100vh / var(--grid-rows)) * var(--footer-height));

  @media (orientation: portrait) {
    /* flex-direction: column-reverse;
    align-items: flex-start;
    row-gap: calc(var(--border-width) * 2); */
  }
`;

const Img = styled.img`
  max-height: calc(((100vh / var(--grid-rows))*0.5) - calc(var(--border-width) * 6));
  width: auto;
  border: 1px solid hsl(0, 0%, 80%);
`;

Footer.propTypes = {
  footerHeight: PropTypes.string,
  footerImageSrc: PropTypes.string,
  footerBackgroundColor: PropTypes.string,
};

export default Footer;
