import { Card, Image, Icon } from 'semantic-ui-react';
import Header from '../Header';
import Footer from '../Footer';
import alice from '../../assets/alice.png';
import anissa from '../../assets/anissa.png';
import flo from '../../assets/flo.png';
import jeanne from '../../assets/jeanne.jpg';
import sam from '../../assets/sam.jpg';

import './styles.scss';

function GreenTeam() {
  return (
    <>
      <Header />
      <main className="main_greenteam">
        <div className="text_greenteam">
          <h2 className="h2_greenteam">Qui sommes-nous ?</h2>
          <p className="présentation">Chez Adopte Un Arbre, notre passion pour un impact positif sur la nature est soutenue par une équipe talentueuse de cinq développeuses. Nous nous engageons à créer un site web attrayant, intuitif et performant pour encourager notre mission environnementale.</p>
          <h3>Découvrez l'équipe :</h3>
        </div>
        <div className="cards_greenteam_back">
          <Card>
            <Image src={alice} wrapped ui={false} />
            <Card.Content>
              <Card.Header>Alice</Card.Header>
              <Card.Content extra>
                <Icon name="chart bar outline" />
                Product owner
              </Card.Content>
              <Card.Description>
                Développeuse back mais aussi product owner, grâce à ses talents, Alice s'assure que notre site web fonctionne de manière fluide et efficace.
              </Card.Description>
            </Card.Content>
          </Card>
          <Card>
            <Image src={anissa} wrapped ui={false} />
            <Card.Content>
              <Card.Header>Anissa</Card.Header>
              <Card.Content extra>
                <Icon name="write" />
                Scrum master
              </Card.Content>
              <Card.Description>
                Notre développeuse back la plus bavarde mais aussi notre scrum master, Anissa s'assure de l'avancement du projet tout en écrivant du code de qualité.
              </Card.Description>
            </Card.Content>
          </Card>
          <Card>
            <Image src={flo} wrapped ui={false} />
            <Card.Content>
              <Card.Header>Floriane (aka Flo)</Card.Header>
              <Card.Content extra>
                <Icon name="php" />
                Lead dev' back
              </Card.Content>
              <Card.Description>
                Discrète mais ultra efficace, Floriane (aka Flo'), notre lead dev' back, est une programmeuse compétente et rigoureuse !
              </Card.Description>
            </Card.Content>
          </Card>
        </div>
        <div className="cards_greenteam_front">
          <Card>
            <Image src={jeanne} wrapped ui={false} />
            <Card.Content>
              <Card.Header>Jeanne</Card.Header>
              <Card.Content extra>
                <Icon name="github" />
                Git master
              </Card.Content>
              <Card.Description>
                Sa compréhension globale du processus de développement lui permet de créer des fonctionnalités puissantes et interactives.
              </Card.Description>
            </Card.Content>
          </Card>
          <Card>
            <Image src={sam} wrapped ui={false} />
            <Card.Content>
              <Card.Header>Samantha (aka Sam)</Card.Header>
              <Card.Content extra>
                <Icon name="react" />
                Lead dev' front
              </Card.Content>
              <Card.Description>
                Grâce à son inventivité et à son sens du design, Samantha (aka Sam') nous a permis d'avoir un joli site pour vous !
              </Card.Description>
            </Card.Content>
          </Card>
        </div>
        <div className="descriptions">
          <h2 className="h2_greenteam">Un peu plus sur nous</h2>
          <p>
            Notre équipe 100% féminine est animée par la passion pour le développement web. Nous sommes très axées sur la collaboration et le partage des connaissances au sein de l'équipe.
            Chacune des développeuses a suivi une formation approfondie au sein de l’école O’clock, afin d’utiliser des langages de programmation tels que : JavaScript et PHP ainsi que des frameworks populaires comme : React et Symfony.                                                                
          </p>
        </div>
      </main>
      <Footer />
    </>
  );
}

export default GreenTeam;
