<template>
    <section id="banner-area">
        <span aria-hidden="true">🤘</span>
        <article>
            <h2>A fortuna fica ao lado daquele que ousa.</h2>
            <p>Todo progresso ocorre fora da zona de conforto.</p>
        </article>
        <div id="squares-container">
            <div class="square" id="left-square"></div>
            <div class="square" id="right-square">
                <div id="diamond-container">
                    <div id="diamond"></div>
                </div>
            </div>
        </div>
    </section>
</template>


<style scoped>
#banner-area {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 609px;
    height: 599px;
    padding: 45px;
    background-color: #f7f7f7;
    transition: 0.3s;

    & span {
        font-size: 48px;
        font-weight: 600;
        transition: 0.3s;
    }

    & article {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 15px;

        & h2 {
            font-size: 24px;
            font-weight: 700;
            line-height: 36px;
            color: #000000;
            transition: 0.3s;
        }

        & p {
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            color: #000000 ;
            transition: 0.3s;
        }

    }

    & #squares-container {
        display: flex;
        gap: 35px;
        width: 100%;

        & .square {
            width: 100px;
            height: 100px;

        }

        & #left-square {
            background: linear-gradient(90deg, #00000000, #00000067 65%, #00000000);
            transition: 0.5s;
        }

        & #right-square {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000000;
            position: relative;
            transition: 0.3s;

            & #diamond-container {
                width: 70px;
                border: solid transparent;


                & #diamond {
                    width: 0px;
                    height: 0px;
                    border-top: solid transparent 20px;
                    border-bottom: solid transparent 20px;
                    border-right: solid #ffffff4d 35px;
                    -webkit-box-reflect: right;
                    position: absolute;
                    top: 40px;
                    transition: 0.3s;

                }

                & #diamond::after {
                    content: '';
                    width: 0px;
                    height: 0px;
                    border-top: solid transparent 20px;
                    border-bottom: solid transparent 20px;
                    border-right: solid #ffffff 35px;
                    -webkit-box-reflect: right;
                    position: absolute;
                    top: -38px;
                    transition: 0.3s;
                }
            }

        }
    }
}


#banner-area:hover {
    background-color: black;
    & span {
        transform: translateY(25px);
    }

    & article {
        & h2, p {
            color: #ffffff;
        }

        
    }

    & #squares-container {

        & #left-square {
            background: linear-gradient(90deg, #ffffff00, #ffffff15 65%, #ffffff00);
        }

        & #right-square {
            background-color: white;

            & #diamond-container {
                & #diamond {
                    border-right-color:rgba(0, 0, 0, 0.3);
                }

                & #diamond::after {
                    border-right-color:rgb(0, 0, 0);
                }
            }
        }
    }

}
</style>