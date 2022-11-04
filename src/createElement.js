export default function createElement(type, className = null)
{
    let element = document.createElement(type)
    element.className = className

    return element
}