import React, { useState } from "react";
import hexToRgba from "hex-to-rgba";
import styled from "styled-components";
import PropTypes from "prop-types";
import Icon from "./icon";

function GridItem({
  variant,
  description,
  image,
  exposed,
  tileIcons,
  tileBorders,
  exposeFontSize,
  color,
}) {
  const [imageReady, setImageReady] = useState(false);

  return (
    <Wrapper className={exposed ? "exposed" : ""}>
      <ContentWrapper>
        {!imageReady && (
          <Skeleton
            style={{
              "--skeleton-color-1": hexToRgba(color, 0.4),
              "--skeleton-color-2": hexToRgba(color, 0.7),
              "--skeleton-color-3": hexToRgba(color, 1),
            }}
          />
        )}
        <>
          <Item
            onLoad={() => setImageReady(true)}
            src={image}
            className={variant}
            style={{
              "--border-width": tileBorders ? "var(--tile-border-width)" : 0,
              "--overlay-opacity": tileBorders ? "0.1" : "0",
            }}
          />

          {exposed && (
            <ItemDescription
              style={{
                "--text-size": `var(--font-size-${exposeFontSize})`,
              }}
            >
              {description}
            </ItemDescription>
          )}
          {tileIcons && <ItemIcon src={Icon[variant]} alt="" />}
        </>
      </ContentWrapper>
    </Wrapper>
  );
}

GridItem.defaultProps = {
  exposed: false,
  tileIcons: null,
  tileBorders: false,
  exposeFontSize: "",
};

GridItem.propTypes = {
  variant: PropTypes.string.isRequired,
  description: PropTypes.string.isRequired,
  image: PropTypes.string.isRequired,
  exposed: PropTypes.bool,
  tileIcons: PropTypes.bool,
  tileBorders: PropTypes.bool,
  exposeFontSize: PropTypes.string,
};

const ItemDescription = styled.p`
  font-size: var(--text-size);
  font-weight: var(--font-weight-bold);
  line-height: 1.2;
  color: white;
  position: absolute;
  bottom: 22%;
  left: 3%;
  width: 85%;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 4;
  overflow: hidden;
  filter: var(--filter-shadow);
`;

const ItemIcon = styled.img`
  position: absolute;
  bottom: 0;
  left: 0;
  width: auto;
  height: 20%;
`;

const Skeleton = styled.div`
  @keyframes gradient {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }

  width: calc(100vw / var(--grid-columns));
  height: calc(100vh / var(--total-rows));
  background: linear-gradient(
    -45deg,
    var(--skeleton-color-3),
    var(--skeleton-color-2),
    var(--skeleton-color-1)
  );
  background-size: 400% 400%;
  animation: gradient 2s ease infinite;
`;

const ContentWrapper = styled.div`
  position: relative;
`;

const Item = styled.img`
  object-fit: cover;
  position: relative;
  background-position: center;
  background-size: cover;
  border-style: solid;
  border-width: var(--border-width);
  border-color: transparent;
  width: calc(100vw / var(--grid-columns));
  height: calc(100vh / var(--total-rows));
  overflow: hidden;

  &::before {
    content: "";
    position: absolute;
    pointer-events: none;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: var(--overlay-opacity);
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

  .exposed & {
    width: calc((100vw / var(--grid-columns)) * var(--grid-expose));
    height: calc((100vh / var(--total-rows)) * var(--grid-expose));
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
`;

const Wrapper = styled.div`
  &.exposed {
    position: absolute;
    top: calc(100vh / var(--total-rows));
    left: calc(100vw / var(--grid-columns));
  }
`;

export default GridItem;
