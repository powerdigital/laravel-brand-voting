import React, {Component} from 'react';

import Company from './Company';
import Category from "./Category";

const CATEGORIES = [
    {'id': 1, 'value': 'Свыше 200 чел'},
    {'id': 2, 'value': 'От 100 до 200 чел'},
    {'id': 3, 'value': 'От 50 до 100 чел'},
    {'id': 4, 'value': 'От 20 до 50 чел'},
    {'id': 5, 'value': 'До 20 чел'},
];

export default class Main extends Component {
    constructor() {
        super();

        this.state = {
            data: [],
        }
    }

    componentDidMount() {
        fetch('/company')
            .then((response) => {
                return response.json();
            })
            .then(data => {
                this.setState({data});
            });
    }

    renderCategories() {
        return CATEGORIES.map(category => {
            return (
                <Category category={category} key={category.id}/>
            );
        })
    }

    renderCompanies() {
        if (typeof this.state.data === 'undefined' || this.state.data.length === 0) {
            return;
        }

        return this.state.data.companies.map(company => {
            company.votes = this.state.data.votes[company.id] ? this.state.data.votes[company.id] : 0;

            return (
                <Company company={company} key={company.id}/>
            );
        })
    }

    render() {
        return (
            <div>
                <div className="categories">
                    <a href='/'>Все</a>
                    {this.renderCategories()}
                </div>

                <div className="album py-5 bg-light">
                    <div className="container">
                        <div className="row">
                            {this.renderCompanies()}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
