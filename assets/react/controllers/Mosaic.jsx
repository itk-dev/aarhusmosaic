import React, {useEffect, useState} from "react";
import GlobalStyles from '../GlobalStyles';
import GridItem from '../Components/GridItem';
import Logo from "../Components/Logo";
import Grid from "../Components/Grid";
import LoaderSrc from "../assets/loader.svg";

function Mosaic() {
    const TILES_LOADING_INTERVAL = 60 * 1000 * 5;

    const [screen, setScreen] = useState(null);
    const [config, setConfig] = useState(null);
    const [tiles, setTiles] = useState([]);
    const [randomExpose, setRandomExpose] = useState(1);

    const loadScreen = () => {
        // TODO: Get access token and id 1.
        fetch('/api/v1/screens/1', {
            headers: {
                authorization: "Bearer 123456789"
            }
        }).then((resp) => resp.json()).then((data) => setScreen(data));
    }

    const loadTiles = (numberOfTiles) => {
        // TODO: Get access token.
        fetch(`/api/v1/tiles/random?page=1&limit=${numberOfTiles}`, {
            headers: {
                authorization: "Bearer 123456789"
            }
        }).then((resp) => resp.json()).then((data) => {
            const loadedTiles = [...data['hydra:member']];
            setTiles(loadedTiles.map((tile) => {
                tile.extra = JSON.parse(tile.extra);
                return tile;
            }));
        });
    }

    useEffect(() => {
        loadScreen();

        setInterval(loadTiles, TILES_LOADING_INTERVAL);
    }, []);

    useEffect(() => {
        if (screen === null) {
            return;
        }

        const numberOfTiles = screen.gridColumns * screen.gridRows;

        setConfig({
            gridColumns: screen.gridColumns ?? 6,
            gridRows: screen.gridRows ?? 5,
            numberOfTiles,
            variant: JSON.parse(screen.variant),
        });

        loadTiles(numberOfTiles);
    }, [screen]);

    useEffect(() => {
        if (tiles.length === 0) {
            return;
        }

        const timer = setInterval(() => {
            setRandomExpose(Math.floor(1 + Math.random() * (tiles.length - 1)));
        }, config?.variant?.exposeTimeout ? config.variant.exposeTimeout * 1000  : 5000);

        // Unmount.
        return () => {
            clearInterval(timer);
        }
    }, [tiles]);

    return (<>
            {!config && (
                <div style={{position: "absolute", flexFlow: "wrap", width: "100%", height: "100%", display: "flex", justifyContent: "center", alignContent: "center", background: "rgb(241, 242, 243)"}}>
                    <img alt="loader" src={LoaderSrc} style={{height: "33%"}} />
                </div>
            )}
            {config && tiles.length > 0 && (
                <div className="App">
                    <Grid style={{'--grid-columns': config.gridColumns, '--grid-rows': config.gridRows,}}>
                        {tiles.map((item, index) => (
                            <GridItem
                                key={index}
                                variant={item?.extra?.variant}
                                description={item.description}
                                image={item.image}
                                showIcons={config?.variant?.showIcons ?? false}
                                showBorders={config?.variant?.showBorders ?? false}
                            />
                        ))}
                    </Grid>

                    <GridItem
                        variant={tiles[randomExpose].variant}
                        description={tiles[randomExpose].description}
                        image={tiles[randomExpose].image}
                        exposed
                        showIcons={config?.variant?.exposeShowIcon ?? false}
                        showBorders={config?.variant?.exposeShowBorder ?? false}
                    />

                    {config?.variant?.mosaicLogo && <Logo/>}

                    <GlobalStyles config={config}/>
                </div>
            )}
        </>
    );
}

export default Mosaic;
