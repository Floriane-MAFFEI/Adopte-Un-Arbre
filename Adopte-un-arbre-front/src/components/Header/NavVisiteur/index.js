import '../styles.scss';
import { Link } from 'react-router-dom';

function NavVisiteur() {
  return (
    <nav>
      <Link className="link" to="/">Accueil</Link>
      <Link className="link" to="/projets">Projets</Link>
      <Link className="link" to="/greenteam">Green Team</Link>
      <Link className="link" to="/inscription">Inscription</Link>
      <Link className="link" to="/connexion">Connexion</Link>
    </nav>
  );
}

export default NavVisiteur;
