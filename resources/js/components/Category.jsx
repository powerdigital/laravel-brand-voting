import React, {Component} from 'react';

export default class Category extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <a href={'/category/' + this.props.category.id}>{this.props.category.value}</a>
        )
    }
}
