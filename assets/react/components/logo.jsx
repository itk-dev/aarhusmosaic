import React from "react";
import styled from "styled-components";
import Icon from "./icon";

function Logo() {
  return <LogoImg src={Icon.verdensmaal} alt="" />;
}

const LogoImg = styled.img`
  position: fixed;
  bottom: calc(var(--border-width) * 3);
  right: calc(var(--border-width) * 3);
  border: calc(var(--border-width) * 2) solid var(--logo-background);
  background-color: var(--logo-background);
  filter: var(--filter-shadow);
`;

export default Logo;
