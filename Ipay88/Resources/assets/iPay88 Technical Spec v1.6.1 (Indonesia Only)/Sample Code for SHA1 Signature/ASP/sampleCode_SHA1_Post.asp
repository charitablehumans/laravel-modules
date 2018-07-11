<%	
'===================================== Start POST ====================================================

Response.Write GetHash(SHA1Signature)
Function GetHash(ByVal Source)

	on error resume next
		QString = "Source=" & Source
		URL = "https://payment.ipay88.co.id/DotNet/SHA1Hash.aspx"
		Dim strReturn, TryNo
		strReturn = ""
		TryNo = 1
			Set xobj = Server.CreateObject ("MSXML2.ServerXMLHTTP")		
			xobj.open "POST", URL, false
			xobj.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
			xobj.send QString
			strReturn = xobj.responseText	
			Set xobj = nothing
			
		If Err.number <> 0 then
			GetHash = ""
			Err.Clear
		else
			GetHash = Mid(strReturn,InStr(strReturn,"<hash>")+6,InStr(strReturn,"</hash>")-7)
		End If
End Function


'====================================== End POST ====================================================

%>