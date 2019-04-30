import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import Header from './Header';
import Footer from './Footer';
import Main from "./Main";

ReactDOM.render(<Header/>, document.getElementById('header'));
ReactDOM.render(<Main/>, document.getElementById('main'));
ReactDOM.render(<Footer/>, document.getElementById('footer'));
