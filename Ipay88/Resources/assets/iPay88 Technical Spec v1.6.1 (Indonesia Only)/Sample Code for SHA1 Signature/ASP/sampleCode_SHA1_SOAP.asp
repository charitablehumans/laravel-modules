<%
'===================================== Start SOAP 1.1 ====================================================

Const SoapServer	= "payment.ipay88.co.id"
Const SoapPath		= "/ePayment/Security/Security.asmx"
Const SoapAction	= "Signature"
Const SoapNamespace = "https://payment.ipay88.co.id/"
		
'Response.write "<br>Hash : " & getHash("appleM00123A000000014500MYR")

Function getHash(strToHash)
	SoapBody = xmlSoap(strToHash)
	
	if SoapBody = "" then
			%><table><tr><td><b>Empty Soap Body Response</b></td></tr></table><%
	else
		dim xml
		on error resume next
		set xml = Server.CreateObject("Microsoft.XMLDOM")
		if(err.number = 0) then		
			xml.async = False
			xml.loadxml(SoapBody) 
			dim oNode : set oNode = xml.selectSingleNode("soap:Envelope/soap:Body/SignatureResponse")
						
						getHash = oNode.SelectSingleNode("SignatureResult").Text
							
			set xml = nothing
		else
			%>
				<table>
					<tr>
						<td align="left">This objects requires Microsofts XML Parser 3.0 SP2 or greater.</td>
					</tr>
					<tr>
						<td>Download here: <a href="http://download.microsoft.com/download/xml/SP/3.20/W9X2KMeXP/EN-US/msxml3sp2Setup.exe">http://download.microsoft.com/download/xml/SP/3.20/W9X2KMeXP/EN-US/msxml3sp2Setup.exe</a></td>
					</tr>	
				</table>
			<%	
			Response.Write("Error: " & err.number)
		end if
	end if
End Function


function xmlSoap(strKey)
	' Instantiate objects to hold the XML DOM and the HTTP/XML communication:
	' Instantiate object for HTTP/XML communication:
	Dim xmlhttp, strSoap
	Set xmlhttp = Server.CreateObject("Msxml2.ServerXMLHTTP")
	
	' Build XML document:
	strSoap =	"<?xml version=""1.0"" encoding=""utf-8""?>" & _
				"<soap:Envelope xmlns:xsi=""http://www.w3.org/2001/XMLSchema-instance"" xmlns:xsd=""http://www.w3.org/2001/XMLSchema"" xmlns:soap=""http://schemas.xmlsoap.org/soap/envelope/"">" & _
				"<soap:Body>" & _
				"<" & SoapAction & " xmlns=""" & SoapNamespace & """>" & _
				"<Key>" & strKey & "</Key>" & _
				"</" & SoapAction & ">" & _
				"</soap:Body>" & _
				"</soap:Envelope>"
				
	'Build custom HTTP header:
	xmlhttp.Open "POST", "http://" & SoapServer & SoapPath, False	' False = Do not respond immediately
	xmlhttp.setRequestHeader "Man", "POST " & SoapPath & " HTTP/1.1"
	xmlhttp.setRequestHeader "Host", SoapServer
	xmlhttp.setRequestHeader "Content-Type", "text/xml; charset=utf-8"
	xmlhttp.setRequestHeader "SOAPAction", SoapNamespace & SoapAction

	'Send it using the header generated above:
	xmlhttp.send(strSoap)
	
 	if xmlhttp.Status = 200 then			' Response from server was success
 		xmlSoap = xmlhttp.responseText		' note xmlSoap is the function name hence the return value is a string Varient
	else									' Response from server failed
		xmlSoap = ""
	' Tell administrator what went wrong - maybe not users though
		Response.Write("Server Error.<br>")
		Response.Write("status = " & xmlhttp.status)
		Response.Write("<br>" & xmlhttp.statusText & "<br>" & xmlhttp.responseText)
		Response.Write("<br><pre>" & Request.ServerVariables("ALL_HTTP") & "</pre>")
	end If
	Set xmlhttp = nothing
end function


'======================================= End SOAP ====================================================
%>