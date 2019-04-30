import React, {Component} from 'react';

export default class Header extends Component {
    render() {
        return (
            <div>
                <div className="navbar navbar-dark bg-dark shadow-sm">
                    <div className="container d-flex justify-content-between">
                        <a href="/" className="navbar-brand d-flex align-items-center">
                            <span className="logo"></span>
                        </a>
                    </div>
                </div>
                <div className="bg-dark" id="navbarHeader">
                    <div className="container">
                        <div className="row">
                            <div className="col-sm-8 col-md-8 py-2">
                                <p className="text-white">HR Brand Crimea - первая премия за лучший бренд
                                    компании-работодателя в Крыму.</p>
                                <button type="button" className="conditions btn btn-sm btn-primary" data-toggle="modal"
                                        data-target=".bd-example-modal-lg">Условия конкурса
                                </button>
                            </div>
                            <div className="col-sm-4 py-2">
                                <h4 className="text-orange">Контакты</h4>
                                <ul className="list-unstyled">
                                    <li><a href="tel:+79785555555" className="text-white">+7 978 555-55-55</a></li>
                                    <li><a href="http://hrdaycrimea.ru" className="text-white"
                                           target="_blank">Организаторы</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
