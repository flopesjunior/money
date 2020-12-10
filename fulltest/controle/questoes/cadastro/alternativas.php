<?
require_once('../../../indicadores.ini.php');

?>

  <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
    <tr><td height="10px" colsoan="2"></td></tr>
    <tr>
        <td align=left colspan="2">
            <b>Importante:</b> Após digitar as alternativas, clique no numero para marcar a correta.
        </td>
    </tr>
    <tr><td height="10px" colsoan="2"></td></tr>
    <tr>
        <td align=left width=3%> <div id="alt1"> <button type="button" class="btn btn-default btn-circle"  onclick="seleciona_alternativa(1)" >1</button> </div> </td>    
        <td align=left width=97%>
              <textarea class='form-control' name='txt_alternativa_1' id='txt_alternativa_1' rows='2'></textarea>
        </td>
    </tr>
    <tr><td height="10px" colsoan="2"></td></tr>
    <tr>
        <td align=left width=1%> <div id="alt2"><button type="button" class="btn btn-default btn-circle" onclick="seleciona_alternativa(2)">2</button> </div> </td>    
        <td align=left width=99%>
              <textarea class='form-control' name='txt_alternativa_2' id='txt_alternativa_2' rows='2'></textarea>
        </td>
    </tr>
    <tr><td height="10px" colsoan="2"></td></tr>
    <tr>
        <td align=left width=1%> <div id="alt3"><button type="button" class="btn btn-default btn-circle" onclick="seleciona_alternativa(3)">3</button> </div></td>    
        <td align=left width=99%>
              <textarea class='form-control' name='txt_alternativa_3' id='txt_alternativa_3' rows='2'></textarea>
        </td>
    </tr>
    <tr><td height="10px" colsoan="2"></td></tr>
    <tr>
        <td align=left width=1%> <div id="alt4"><button type="button" class="btn btn-default btn-circle" onclick="seleciona_alternativa(4)">4</button> </div> </td>    
        <td align=left width=99%>
              <textarea class='form-control' name='txt_alternativa_4' id='txt_alternativa_4' rows='2'></textarea>
        </td>
    </tr>
    <tr><td height="10px" colsoan="2"></td></tr>
    <tr>
        <td align=left width=1%> <div id="alt5"><button type="button" class="btn btn-default btn-circle" onclick="seleciona_alternativa(5)">5</button> </div></td>    
        <td align=left width=99%>
              <textarea class='form-control' name='txt_alternativa_5' id='txt_alternativa_5' rows='2'></textarea>
        </td>
    </tr>
</table> 