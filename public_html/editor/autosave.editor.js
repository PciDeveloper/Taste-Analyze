function get_editor_wr_content()
{
    return oEditors.getById['content'].getIR();;
}

function put_editor_wr_content(content)
{
    oEditors.getById["content"].exec("SET_CONTENTS", [""]);
    //oEditors.getById["wr_content"].exec("SET_IR", [""]);
    oEditors.getById["content"].exec("PASTE_HTML", [content]);

    return;
}