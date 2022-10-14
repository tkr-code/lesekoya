/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import { createRoot } from 'react-dom/client';
import React from 'react';
import Article from './Components/Article';
import Home from './Components/Home';


class App extends React.Component {
     render() {
         return <div>
            <Home/>
            <Article/>
         </div>
     }
 }
const root = createRoot(document.getElementById('root'));
root.render(<App/>);
