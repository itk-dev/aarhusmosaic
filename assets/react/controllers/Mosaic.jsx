import React, { useEffect, useState } from "react";

import styled from 'styled-components'
import GlobalStyles from '../GlobalStyles';
import GridItem from '../Components/GridItem/GridItem';
import Logo from "../Components/Logo/Logo";
import { Data } from '../Data/demoData';
import { Settings } from '../Data/settings';
import PropTypes from "prop-types";

function Mosaic({exampleProp}) {
    const [randomExpose, setRandomExpose] = useState(1);

    useEffect(() => {
        // TODO: Remove.
        console.log('exampleProp', exampleProp)

        const timer = setInterval(() => {
            setRandomExpose(Math.floor(1 + Math.random() * (Data.length - 1)));
        }, 5000);

        // Unmount.
        return () => {
            clearInterval(timer);
        }
    }, []);

    return (
        <div className="App">
            <Grid style={{ '--grid-columns': Settings.columns, '--grid-rows': Settings.rows, }}>
                {Data.map((item, index) => (
                    <GridItem
                        key={index}
                        variant={item.variant}
                        description={item.description}
                        image={item.image}
                        showIcons={Settings.showIcons}
                    />
                ))}
            </Grid>

            <GridItem
                variant={Data[randomExpose].variant}
                description={Data[randomExpose].description}
                image={Data[randomExpose].image}
                exposed

            />

            {Settings.showLogo && <Logo />}
            <GlobalStyles />
        </div>
    );
}

// TODO: Move to separate file.
const Grid = styled.div`
  display: grid;
  grid-template-rows: repeat(var(--grid-rows), 1fr);
  grid-template-columns: repeat(var(--grid-columns), 1fr);
  gap: 0;
`;



Mosaic.propTypes = {
    exampleProp: PropTypes.string.isRequired,
}

export default Mosaic;
