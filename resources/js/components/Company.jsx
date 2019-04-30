import React, {Component} from 'react';

const CATEGORIES = {
    1: 'Свыше 200 чел',
    2: 'От 100 до 200 чел',
    3: 'От 50 до 100 чел',
    4: 'От 20 до 50 чел',
    5: 'До 20 чел'
};

export default class Company extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="col-md-4 mb-2 company">
                <div className="card mb-4 shadow-sm">
                    <img src={'/img/' + this.props.company.logo + '.jpg'} alt="name"/>
                    <div className="card-body">
                        <div className="card-left col-9 float-left">
                            <ul>
                                <li className="company-name">{this.props.company.name}</li>
                                <li className="company-category">
                                    <small>{CATEGORIES[this.props.company.category_id]}</small>
                                </li>
                                <li className="company-desc">
                                    <small>{this.props.company.description}</small>
                                </li>
                                <li className="company-details">
                                    <a href="" data-toggle="modal"
                                       data-target="#companyModal">Подробнее...</a>
                                </li>
                            </ul>
                        </div>
                        <div className="card-right col-3 float-left">
                            <div className="score">
                                <span className="text-primary text-weight-bold">
                                    {this.props.company.votes}
                                </span>
                            </div>
                            <div className="d-flex justify-content-between align-items-center">
                                <div className="btn-group">
                                    <div className="like" data-toggle="modal" data-target="#authModal"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
