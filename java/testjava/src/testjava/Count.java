package testjava;

public class Count {
	 Value3 v = new Value3(10);

	    static Value3 v1, v2;

	    static {//�˼�Ϊstatic��
	    	System.out.println("<<><><><><>");
	       prt("v1.c=" + v1.c + "  v2.c=" + v2.c);
	       System.out.println("<<><><><><>");
	       v1 = new Value3(27);

	       prt("v1.c=" + v1.c + "  v2.c=" + v2.c);

	       v2 = new Value3(15);

	       prt("v1.c=" + v1.c + "  v2.c=" + v2.c);

	    }
	
	public static void prt(String s) {
	       System.out.println(s);
	    }


	   

	 

	    public static void main(String[] args) {

	       Count ct = new Count();
	       System.out.println("<-------------------->");

	       prt("ct.c=" + ct.v.c);
	       
	       System.out.println("<-------------------->");

	       prt("v1.c=" + v1.c + "  v2.c=" + v2.c);

	       v1.inc();

	       prt("v1.c=" + v1.c + "  v2.c=" + v2.c);

	       prt("ct.c=" + ct.v.c);

	    }
}
