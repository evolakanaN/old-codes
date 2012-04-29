using System;
using System.IO;
using System.Net;
using System.Web;
using System.Text;
using System.Net.Mail;
using System.Collections.Generic;
using System.ComponentModel;
using System.Text.RegularExpressions;
using System.Runtime.InteropServices;
using System.Web.Script.Serialization;
 
namespace Sn0wNight
{
    class TwitterEarthquakeNotification
    {
        [DllImport("user32.dll")]
        extern static int MessageBeep(uint hex);
 
        public static void Main(string[] args)
        {
            string u = "http://stream.twitter.com/1/statuses/sample.json";
            string p = "C:\\quake\\auth_config.ini";
            string p1 = "C:\\quake\\settings.ini";
 
            ReadConfigClass ri = new ReadConfigClass();
            string auth = ri.Read(p,"LOGIN","ACCOUNT");
 
            Console.WriteLine("[*]設定情報(ini)をロードしました");
            if(System.Net.NetworkInformation.NetworkInterface.GetIsNetworkAvailable())
            {
                Console.WriteLine("[*]ネットワークへの正常接続を確認しました");
 
                string[] auth_i = auth.Split(',');
                HttpWebRequest http_req = (HttpWebRequest)WebRequest.Create(u);
                NetworkCredential cred = new NetworkCredential(auth_i[0].ToString(),auth_i[1].ToString());
                http_req.Credentials = cred;
 
                Console.WriteLine("[*]地震発生を確認次第通知します\n");
                int cnt = 0;
                int cnt_l = 0;
 
                while(true)
                {
                    STREAMING:
                        HttpWebResponse http_res = (HttpWebResponse)http_req.GetResponse();
                        Stream st = http_res.GetResponseStream();
                        StreamReader sr = new StreamReader(st);
 
                        string li = sr.ReadLine();
                        JavaScriptSerializer js = new JavaScriptSerializer();
                        Dictionary<string,object> d = js.Deserialize<Dictionary<string,object>>(li);
 
                        if(d.ContainsKey("text"))
                        {
                            Dictionary<string,object>s = (Dictionary<string, object>)d["user"];
 
                            Regex r1 = new Regex(@"[ゆ揺]れてる|地震だ|じしんだ|地震ﾅ[ｰー]");
                            Regex r2 = new Regex(@"北海道|青森|岩手|宮城|秋田|山形|福島|茨城|栃木|群馬|埼玉|千葉|東京|神奈川|新潟|富山|石川|福井|山梨|長野|岐阜|静岡|愛知|三重|滋賀|京都|大阪|兵庫|奈良|和歌山|鳥取|島根|岡山|広島|山口|徳島|香川|愛媛|高知|福岡|佐賀|長崎|熊本|大分|宮崎|鹿児島|沖縄");
 
                            try
                            {
                                if(r1.IsMatch(d["text"].ToString()) && r2.IsMatch(s["location"].ToString()))
                                {
                                    DateTime dt = DateTime.Now;
 
                                    string ps = dt + "+00000 :"+s["location"]+"周辺で地震が発生したようです";
                                    MessageBeep(0x30);
 
                                    Console.WriteLine(ps);
 
                                    string settings = ri.Read(p1,"SETTINGS","USER");
                                    string[] sp = settings.Split(',');
 
                                    Regex r3 = new Regex(sp[1].ToString());
                                    if (r3.IsMatch(ps))
                                    {
                                        if (cnt >= 3)
                                        {
 
                                            if (cnt_l == 0)
                                            {
                                                Console.WriteLine("\n[*]お住まいの地域で地震が確認されました。メールを送信します");
                                                try
                                                {
                                                    GmailSend gs = new GmailSend();
                                                    gs.SendMail(sp[2].ToString(), sp[3].ToString(), sp[4].ToString());
                                                    Console.WriteLine("[*]メールを送信しました\n");
                                                }
                                                catch (Exception)
                                                {
                                                    Console.WriteLine("[ERROR]:メールを送信できませんでした\n");
                                                }
                                            }
                                            cnt_l += 1;
                                        }
                                        cnt += 1;
                                    }
                                }
                            }
                            catch(NullReferenceException)
                            {
                                goto STREAMING;
                            }
                        }
                }
            }
            else
            {
                Console.WriteLine("[ERROR]:ネットワークに接続されていません");
                return;
            }
        }
    }
    public class ReadConfigClass
    {
        [DllImport("kernel32.dll",EntryPoint="GetPrivateProfileString")]
        private static extern uint GetPrivateProfileString(string arg1, string arg2, string arg3, StringBuilder arg4, uint arg5, string arg6);
 
        public string Read(string p,string k,string v)
        {
            StringBuilder str = new StringBuilder(0xFF);
            uint len = GetPrivateProfileString(k,v,"Nothing",str,(uint)(str.Capacity),p);
            string r_val = str.ToString();
            return r_val;
        }
    }
    public class GmailSend
    {
        public void SendMail(string f, string s, string pass)
        {
            SmtpClient smtp = new SmtpClient("smtp.gmail.com",587);
            smtp.EnableSsl = true;
            smtp.Credentials = new NetworkCredential(s,pass);
            MailMessage m = new MailMessage(f,f,"地震速報プログラムより","お住まいの地域で地震が観測されたとの情報が観測されています。\r\n今後の情報にお気をつけ下さい");
            smtp.Send(m);
        }
    }
}