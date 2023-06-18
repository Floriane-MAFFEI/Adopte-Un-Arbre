import './styles.scss';
import { useSelector } from 'react-redux';
import logo from '../../assets/logo.png';
import NavVisiteur from './NavVisiteur';
import NavUtilisateur from './NavUtilisateur';

function Header() {
  const count = useSelector((state) => state.trees.count);
  const role = useSelector((state) => state.users.roles);

  const isLogged = localStorage.getItem('token');

  return (
    <header>
      <img src={logo} alt="logo" />
      <p className="compteur"> {count} arbres plantés</p>
      {
      isLogged ? <NavUtilisateur role={role} /> : <NavVisiteur />
      }
    </header>
  );
}

export default Header;
