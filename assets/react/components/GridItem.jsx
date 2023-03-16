import React from "react";
import styled from 'styled-components'
import Icon from './icon';

const GridItem = ({ variant, description, image, exposed, showIcons, showBorders }) => {
  return (
    <Wrapper className={exposed ? "exposed" : ""}>
      <Item className={variant} style={{ '--background-image': `url(${image}`, '--border-width': showBorders ? 'var(--tile-border-width)' : 0  }}>
        {exposed && <ItemDescription>{description}</ItemDescription>}
        {showIcons && <ItemIcon src={Icon[variant]} alt=""/>}
      </Item>
    </Wrapper>
  );
}

const ItemDescription = styled.p`
  font-size: var(--font-size-h2);
  font-weight: var(--font-weight-h2);
  line-height: 1.2;
  color: white;
  position: absolute;
  bottom: 22%;
  left: 1%;
  width: 85%;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 4;
  overflow: hidden;
  filter: var(--filter-shadow);
`

const ItemIcon = styled.img`
  position: absolute;
  bottom: 0;
  left: 0;
  width: auto;
  height: 20%;
`

const Item = styled.div`
  position: relative;
  background-image: var(--background-image);
  background-position: center;
  background-size: cover;
  border-style: solid;
  border-width: var(--border-width);
  border-color: transparent;
  width: calc(100vw / var(--grid-columns));
  height: calc(100vh / var(--grid-rows));
  overflow: hidden;

  &::before {
    content: "";
    position: absolute;
    pointer-events: none;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.1;
  }

  &.one {
    border-color: var(--color-one);
    &::before {
      background-color: var(--color-one);
    }
  }

  &.two {
    border-color: var(--color-two);
    &::before {
      background-color: var(--color-two);
    }
  }

  &.tree {
    border-color: var(--color-tree);
    &::before {
      background-color: var(--color-tree);
    }
  }

  &.four {
    border-color: var(--color-four);
    &::before {
      background-color: var(--color-four);
    }
  }

  &.five {
    border-color: var(--color-five);
    &::before {
      background-color: var(--color-five);
    }
  }

  &.six {
    border-color: var(--color-six);
    &::before {
      background-color: var(--color-six);
    }
  }

  &.seven {
    border-color: var(--color-seven);
    &::before {
      background-color: var(--color-seven);
    }
  }

  &.eight {
    border-color: var(--color-eight);
    &::before {
      background-color: var(--color-eight);
    }
  }

  &.nine {
    border-color: var(--color-nine);
    &::before {
      background-color: var(--color-nine);
    }
  }

  &.ten {
    border-color: var(--color-ten);
    &::before {
      background-color: var(--color-ten);
    }
  }

  &.eleven {
    border-color: var(--color-eleven);
    &::before {
      background-color: var(--color-eleven);
    }
  }

  &.twelve {
    border-color: var(--color-twelve);
    &::before {
      background-color: var(--color-twelve);
    }
  }

  &.thirteen {
    border-color: var(--color-thirteen);
    &::before {
      background-color: var(--color-thirteen);
    }
  }

  &.fourteen {
    border-color: var(--color-fourteen);
    &::before {
      background-color: var(--color-fourteen);
    }
  }

  &.fifteen {
    border-color: var(--color-fifteen);
    &::before {
      background-color: var(--color-fifteen);
    }
  }

  &.sixteen {
    border-color: var(--color-sixteen);
    &::before {
      background-color: var(--color-sixteen);
    }
  }

  .exposed &{
    width: calc((100vw / var(--grid-columns)) * var(--grid-expose));
    height: calc((100vh / var(--grid-rows)) *  var(--grid-expose));
    animation: expose;
    animation-duration: 1.2s;
    transform-origin: bottom;
    transition-timing-function: cubic-bezier(0.26, 0.34, 0.49, 0.98);
  }

  &.animate-in {
    animation: expose;
  }

  &.animate-out {
    animation: expose;
    animation-direction: alternate;
  }

`

const Wrapper = styled.div`
  &.exposed {
    position: absolute;
    top: calc(100vh / var(--grid-rows));
    left: calc(100vw / var(--grid-columns));
  }
`

export default GridItem;
