import React from "react";
import styled from 'styled-components'

function Grid(props) {
  return (
    <Wrapper {...props}>
      {props.children}
    </Wrapper>
  );
}

const Wrapper = styled.div`
  display: grid;
  grid-template-rows: repeat(var(--grid-rows), 1fr);
  grid-template-columns: repeat(var(--grid-columns), 1fr);
  gap: 0;
  height: calc((100vh / var(--total-rows)) * var(--grid-rows))
`;

export default Grid;
