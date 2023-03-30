import React from "react";
import styled from 'styled-components'
import PropTypes from "prop-types";

function CtaBox({title, description, image, backgroundColor}) {
  return (
    <Wrapper style={{
        '--background-color': backgroundColor
    }}>
      {image && <Img src={image} alt=""/>}
      <div>
        <Title>{title}</Title>
        {description && <Description>{description}</Description>}
      </div>
    </Wrapper>
  );
}

const Wrapper = styled.div`
  position: fixed;
  max-width: calc(((100vw / var(--grid-columns))*2) - calc(var(--border-width) * 6));
  bottom: calc(var(--border-width) * 3);
  left: calc(var(--border-width) * 3);
  background-color: var(--background-color, hsl(0deg 0% 100%));
  border: calc(var(--border-width) * 2) solid var(--background-color);
  filter: var(--filter-shadow);
  display: flex;
  column-gap: calc(var(--border-width) * 2);

  @media (orientation: portrait) {
    flex-direction: column-reverse;
    align-items: flex-start;
    row-gap: calc(var(--border-width) * 2);
  }
`;

const Title = styled.p`
  font-size: calc(var(--font-size-base) * 0.75);
  font-weight: var(--font-weight-bold);
  margin: 0;
  line-height: 1.25;
`;

const Description = styled.p`
  font-size: calc(var(--font-size-base) * 0.5);
  font-weight: var(--font-weight-normal);
  margin: var(--border-width) 0 0 0;
  line-height: 1.25;
`;

const Img = styled.img`
  max-height: calc(((100vh / var(--grid-rows))*0.5) - calc(var(--border-width) * 6));
  width: auto;
  border: 1px solid hsl(0, 0%, 80%);
`;

CtaBox.propTypes = {
  title: PropTypes.string,
  description: PropTypes.string,
  image: PropTypes.string,
  backgroundColor: PropTypes.string,
};

export default CtaBox;
