import React from "react";
import styled from 'styled-components'
import PropTypes from "prop-types";

function Footer({footerHeight, footerImageSrc, footerBackgroundColor}) {
  return (
    <Wrapper style={{
        '--background-color': footerBackgroundColor,
        '--footer-height': footerHeight,
    }}>
      <Img src={footerImageSrc} alt="test"/>
    </Wrapper>
  );
}

const Wrapper = styled.div`
  background-color: var(--background-color, hsl(0deg 0% 100%));
  filter: var(--filter-shadow);
  width: 100vw;
  height: calc((100vh / var(--total-rows)) * var(--footer-height));
  display: grid;
  place-content: center;
`;

const Img = styled.img`
  max-height: calc((100vh / var(--total-rows)) * var(--footer-height));
  width: auto;
`;

Footer.propTypes = {
  footerHeight: PropTypes.string,
  footerImageSrc: PropTypes.string,
  footerBackgroundColor: PropTypes.string,
};

export default Footer;
