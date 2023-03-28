import React, {createRef, useEffect, useState} from "react";
import GlobalStyles from '../global-styles';
import GridItem from '../components/grid-item';
import Logo from "../components/logo";
import Grid from "../components/grid";
import LoaderSrc from "../assets/icons/loader.svg";
import {CenteredContent} from "../components/centered-content";
import {TransitionGroup, CSSTransition} from "react-transition-group";
import CtaBox from "../components/cta-box";

function Mosaic() {
    const TILES_LOADING_INTERVAL = 60 * 1000 * 5;

    const [params, setParams] = useState(null);
    const [screen, setScreen] = useState(null);
    const [config, setConfig] = useState(null);
    const [tiles, setTiles] = useState([]);
    const [randomExpose, setRandomExpose] = useState(1);
    const [errorMessage, setErrorMessage] = useState(null);
    const [nodeRefs, setNodeRefs] = useState({});

    const loadScreen = () => {
        fetch(`/api/v1/screens/${params.id}`, {
            headers: {
                authorization: `Bearer ${params.key}`
            }
        })
            .then((resp) => {
                if (!resp.ok) {
                    throw new Error("Could not fetch screen config");
                }

                return resp.json();
            })
            .then((data) => setScreen(data))
            .catch((err) => {
                setErrorMessage(err.message);
            });
    }

    const loadTiles = () => {
        const errorMessageFailedToFetch = "Could not fetch tiles";

        fetch(`/api/v1/tiles/random?page=1&limit=${config.numberOfTiles}`, {
            headers: {
                authorization: `Bearer ${params.key}`
            }
        })
            .then((resp) => {
                if (!resp.ok) {
                    throw new Error(errorMessageFailedToFetch);
                }

                return resp.json();
            })
            .then((data) => {
                const loadedTiles = [...data['hydra:member']];
                setTiles(loadedTiles.map((tile) => {
                    tile.extra = JSON.parse(tile.extra);
                    return tile;
                }));

                if (errorMessage === errorMessageFailedToFetch) {
                    setErrorMessage(null);
                }
            })
            .catch((err) => {
                if (tiles.length === 0) {
                    setErrorMessage(err.message);
                }
            });
    }

    useEffect(() => {
        const url = new URL(window.location.href);
        const id = url.searchParams.get('id');
        const key = url.searchParams.get('key');

        if (id === null || key === null) {
            setErrorMessage("Id and/or key are not set.")
        } else {
            setParams({id, key});
        }
    }, []);

    useEffect(() => {
        if (params === null) {
            return;
        }

        loadScreen();
    }, [params]);

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
    }, [screen]);

    useEffect(() => {
        if (config === null) {
            return;
        }

        loadTiles();

        setInterval(loadTiles, TILES_LOADING_INTERVAL);
    }, [config]);

    useEffect(() => {
        if (tiles.length === 0) {
            return;
        }

        const timer = setInterval(() => {
            setRandomExpose(Math.floor(Math.random() * (tiles.length - 1)));
        }, config?.variant?.exposeTimeout ? config.variant.exposeTimeout * 1000 : 5000);

        // Add or remove refs.
        setNodeRefs((prevNodeRefs) =>
            tiles.reduce((result, element) => {
                result[element['@id']] = prevNodeRefs[element['@id']] || createRef();
                return result;
            }, {})
        );

        // Unmount.
        return () => {
            clearInterval(timer);
        }
    }, [tiles]);

    const exposedTile = tiles[randomExpose] ?? null;

    return (
        <>
            {errorMessage && (
                <CenteredContent>Error: {errorMessage}</CenteredContent>
            )}
            {!errorMessage && !config && (
                <CenteredContent>
                    <img alt="loader" src={LoaderSrc} style={{height: "33%"}}/>
                </CenteredContent>
            )}
            {!errorMessage && config && tiles.length > 0 && (
                <div className="App">
                    <Grid style={{'--grid-columns': config.gridColumns, '--grid-rows': config.gridRows}}>
                        {tiles.map((tile) => (
                            <GridItem
                                key={tile['@id']}
                                variant={tile?.extra?.variant}
                                description={tile.description}
                                image={tile.image}
                                tileIcons={config.variant.showIcons ?? false}
                                tileBorders={config.variant.showBorders ?? false}
                            />
                        ))}
                    </Grid>

                    <TransitionGroup component={null}>
                        {exposedTile &&
                            <CSSTransition
                                key={exposedTile['@id']}
                                timeout={1200}
                                classNames="exposed-tile"
                                nodeRef={nodeRefs[exposedTile['@id']]}
                            >
                                <GridItem
                                    variant={exposedTile?.extra?.variant}
                                    description={exposedTile.description}
                                    image={exposedTile.image}
                                    exposed
                                    tileIcons={config.variant.exposeShowIcon ?? false}
                                    tileBorders={config.variant.exposeShowBorder ?? false}
                                    exposeFontSize={config.variant.exposeFontSize}
                                    forwardRef={nodeRefs[exposedTile['@id']]}
                                />
                            </CSSTransition>
                        }
                    </TransitionGroup>

                    {config?.variant?.ctaBoxTitle && <CtaBox
                      title={config.variant.ctaBoxTitle}
                      description={config.variant.ctaBoxDescription}
                      image={config.variant.ctaBoxImage}
                      backgroundColor={config.variant.ctaBoxBackgroundColor}
                    />}
                    {config?.variant?.mosaicLogo && <Logo/>}

                    <GlobalStyles config={config}/>
                </div>
            )}
        </>
    );
}

export default Mosaic;
